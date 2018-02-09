// IIFE
(function() {
  u('#register-button').handle('click', onRegister);
  u('#register-form').handle('submit', onRegister);

  // validate
  u('input[name=username]').on('keyup', function(e) {
    validate(this, validator.username);
  });

  u('input[name=password]').on('keyup', function(e) {
    validate(this, validator.password);
    validate(u('input[name=confirmPassword'), validator.confirmPassword);
  });

  u('input[name=confirmPassword]').on('keyup', function(e) {
    validate(this, validator.confirmPassword);
  });

  u('input[name=namaLengkap]').on('keyup', function(e) {
    validate(this, validator.namaLengkap);
  });

  u('input[name=nomorId]').on('keyup', function(e) {
    validate(this, validator.nomorId);
  });

  u('select[name=gender]').on('change', function(e) {
    validate(this, validator.gender);
  });

  u('input[name=tanggalLahir]').on('change', function(e) {
    validate(this, validator.tanggalLahir);
  });

  u('input[name=tanggalLahir]').on('keyup', function(e) {
    validate(this, validator.tanggalLahir);
  });

  u('textarea[name=alamat]').on('keyup', function(e) {
    validate(this, validator.alamat);
  });

  u('input[name=email]').on('keyup', function(e) {
    validate(this, validator.email);
    validate(u('input[name=confirmEmail]'), validator.confirmEmail);
  });

  u('input[name=confirmEmail]').on('keyup', function(e) {
    validate(this, validator.confirmEmail);
  });
})();

var validator = {
  username: composeValidator([
    regexValidator('Username', /^[0-9a-z.]+$/i, 'alfanumerik'),
    requiredValidator('Username'),
  ]),
  password: regexValidator('Password', /^.{6,}$/, 'minimal 6 karakter'),
  confirmPassword: function(value) {
    var passwordValue = u('input[name=password]').first().value;
    if (value !== passwordValue) return ['Konfirmasi password tidak sama'];
    return [];
  },
  namaLengkap: requiredValidator('Nama lengkap'),
  nomorId: regexValidator('Nomor Identitas', /^[0-9]{16}$/, '16 angka'),
  gender: regexValidator('Jenis Kelamin', /^(l|p)$/, 'laki-laki atau perempuan'),
  tanggalLahir: requiredValidator('Tanggal Lahir'),
  alamat: requiredValidator('Alamat'),
  email: regexValidator(
    'Alamat Email',
    /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
    'email'
  ),
  confirmEmail: function(value) {
    var emailValue = u('input[name=email]').first().value;
    if (value !== emailValue) return ['Konfirmasi email tidak sama'];
    return [];
  },
};

function composeValidator(validators) {
  return function(value) {
    var composedErrors = validators.map(function(validator) {
      return validator(value);
    });
    var errors = [];
    composedErrors.forEach(function(error) {
      errors = errors.concat(error);
    });
    return errors;
  };
}

function requiredValidator(prefix, value) {
  return function(value) {
    if (value) return [];
    return [prefix + ' harus diisi'];
  };
}

function regexValidator(prefix, regex, regexName) {
  var message = prefix + ' harus memenuhi format';
  if (regexName) message += ' ' + regexName;

  return function(value) {
    if (value.match(regex)) return [];
    return [message];
  };
}

function validate(query, val_func) {
  var e = u(query);
  var errors = val_func(e.first().value);
  e.siblings('.error').remove();
  if (errors.length === 0) {
    return true;
  } else {
    errors.forEach(function(error, index) {
      e.after('<div class="error">' + error + '</div>');
    });
  }
}

function onRegister() {
  u('#register-button').attr('disabled', 'true');

  var data = getFormData(u('#register-form').first());

  if (validateForm(data)) {
    u('#register-form').first().submit();
  } else {
    u('#register-button').first().removeAttribute('disabled');
  }
}

function validateForm(data) {
  var flag = true;

  flag &= validate(u('input[name=username]'), validator.username);
  flag &= validate(u('input[name=password]'), validator.password);
  flag &= validate(u('input[name=confirmPassword]'), validator.confirmPassword);
  flag &= validate(u('input[name=namaLengkap]'), validator.namaLengkap);
  flag &= validate(u('input[name=nomorId]'), validator.nomorId);
  flag &= validate(u('select[name=gender]'), validator.gender);
  flag &= validate(u('input[name=tanggalLahir]'), validator.tanggalLahir);
  flag &= validate(u('textarea[name=alamat]'), validator.alamat);
  flag &= validate(u('input[name=email]'), validator.email);
  flag &= validate(u('input[name=confirmEmail]'), validator.confirmEmail);

  return flag;
}

