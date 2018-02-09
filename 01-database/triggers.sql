create or replace function update_jumlah_diterima()
returns trigger as
$$
  declare
    pendaftaran_diterima boolean;
    nomor_periode_new integer;
    nomor_periode_old integer;
    tahun_periode_new char(4);
    tahun_periode_old char(4);
  begin
    if (tg_op = 'UPDATE') then

      select nomor_periode into nomor_periode_new
      from pendaftaran
      where id = new.id_pendaftaran;

      select nomor_periode into nomor_periode_old
      from pendaftaran
      where id = old.id_pendaftaran;

      select tahun_periode into tahun_periode_new
      from pendaftaran
      where id = new.id_pendaftaran;

      select tahun_periode into tahun_periode_old
      from pendaftaran
      where id = old.id_pendaftaran;

      if (new.status_lulus) then
        select count(p) > 0 into pendaftaran_diterima
        from pendaftaran_prodi p
        where p.id_pendaftaran = new.id_pendaftaran
          and kode_prodi <> new.kode_prodi
          and status_lulus = true;

        if (pendaftaran_diterima) then
          raise 'ERROR: Sudah lulus di prodi lain';
        end if;

        update penerimaan_prodi pp
        set jumlah_diterima = jumlah_diterima + 1
        where
          pp.kode_prodi = new.kode_prodi and
          pp.nomor_periode = nomor_periode_new and
          pp.tahun_periode = tahun_periode_new;
      end if;

      if (old.status_lulus) then
        update penerimaan_prodi pp
        set jumlah_diterima = jumlah_diterima - 1
        where
          pp.kode_prodi = old.kode_prodi and
          pp.nomor_periode = nomor_periode_old and
          pp.tahun_periode = tahun_periode_old;
      end if;

    end if;

    return new;
  end;
$$
language plpgsql;

create trigger trigger_jumlah_diterima
before update
on pendaftaran_prodi for each row
execute procedure update_jumlah_diterima();

create or replace function prefill_jumlah_diterima()
returns void as
$$
  declare
    row record;
    jml_diterima integer;
  begin
    for row in
      select * from penerimaan_prodi
    loop
      select count(*) into jml_diterima
      from pendaftaran_prodi pp
      join pendaftaran p on p.id = pp.id_pendaftaran
      where
        pp.kode_prodi = row.kode_prodi and
        p.nomor_periode = row.nomor_periode and
        p.tahun_periode = row.tahun_periode and
        pp.status_lulus = true;

      update penerimaan_prodi
      set jumlah_diterima = jml_diterima
      where
        nomor_periode = row.nomor_periode and
        kode_prodi = row.kode_prodi and
        tahun_periode = row.tahun_periode;
    end loop;
  end;
$$
language plpgsql;

create or replace function update_jumlah_pelamar()
returns trigger as
$$
  declare
    nomor_periode_new integer;
    nomor_periode_old integer;
    tahun_periode_new char(4);
    tahun_periode_old char(4);
    jumlah integer;
    jml_pelamar_1 integer;
    jml_pelamar_2 integer;
  begin
      IF (TG_OP = 'INSERT') THEN
        select nomor_periode into nomor_periode_new
        from pendaftaran
        where id = new.id_pendaftaran;

        select tahun_periode into tahun_periode_new
        from pendaftaran
        where id = new.id_pendaftaran;

        select jumlah_pelamar into jumlah from penerimaan_prodi pp, pendaftaran_prodi p
        where p.id_pendaftaran = new.id_pendaftaran and 
        pp.kode_prodi = NEW.kode_prodi and
        pp.nomor_periode = nomor_periode_new and
        pp.tahun_periode = tahun_periode_new;
        jumlah := jumlah + 1;
      ELSIF (TG_OP = 'DELETE') THEN 
        select nomor_periode into nomor_periode_old
        from pendaftaran
        where id = old.id_pendaftaran;

        select tahun_periode into tahun_periode_old
        from pendaftaran
        where id = old.id_pendaftaran;

        select jumlah_pelamar into jumlah from penerimaan_prodi pp, pendaftaran_prodi p
        where p.id_pendaftaran = new.id_pendaftaran and 
        pp.kode_prodi = NEW.kode_prodi and
        pp.nomor_periode = nomor_periode_new and
        pp.tahun_periode = tahun_periode_new;
        jumlah := jumlah - 1;
      ELSIF (TG_OP = 'UPDATE') THEN

        select nomor_periode into nomor_periode_old
        from pendaftaran
        where id = old.id_pendaftaran;

        select tahun_periode into tahun_periode_old
        from pendaftaran
        where id = old.id_pendaftaran;

        select nomor_periode into nomor_periode_new
        from pendaftaran
        where id = new.id_pendaftaran;

        select tahun_periode into tahun_periode_new
        from pendaftaran
        where id = new.id_pendaftaran;

        select jumlah_pelamar as jml_pelamar_1 from penerimaan_prodi pp, pendaftaran_prodi p
        where p.id_pendaftaran = new.id_pendaftaran and 
        pp.kode_prodi = NEW.kode_prodi and
        pp.nomor_periode = nomor_periode_new and
        pp.tahun_periode = tahun_periode_new;
        select jumlah_pelamar as jml_pelamar_2 from penerimaan_prodi pp, pendaftaran_prodi p
        where p.id_pendaftaran = new.id_pendaftaran and 
        pp.kode_prodi = OLD.kode_prodi and
        pp.nomor_periode = nomor_periode_old and
        pp.tahun_periode = tahun_periode_old;
        jml_pelamar_1 := jml_pelamar_1 + 1;
        jml_pelamar_2 := jml_pelamar_2 - 1;
      END IF; 

    return new;
  end;
$$
language plpgsql;

create trigger trigger_jumlah_pelamar
before update or INSERT or DELETE
on pendaftaran_prodi for each row
execute procedure update_jumlah_pelamar();


create or replace function prefill_jumlah_pelamar()
returns void as
$$
  declare
    row record;
    jml_pelamar integer;
  begin
    for row in
      select * from penerimaan_prodi
    loop
      select count(*) into jml_pelamar
      from pendaftaran_prodi pp
      join pendaftaran p on p.id = pp.id_pendaftaran
      where
        pp.kode_prodi = row.kode_prodi and
        p.nomor_periode = row.nomor_periode and
        p.tahun_periode = row.tahun_periode;

      update penerimaan_prodi
      set jumlah_pelamar = jml_pelamar
      where
        nomor_periode = row.nomor_periode and
        kode_prodi = row.kode_prodi and
        tahun_periode = row.tahun_periode;
    end loop;
  end;
$$
language plpgsql;
