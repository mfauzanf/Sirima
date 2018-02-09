// IIFE
(function() {
  u('#login-button').handle('click', onLogin);
  u('#login-form').handle('submit', onLogin);
})();

function onLogin() {
  u('#login-button').attr('disabled', 'true');

  // simulate ajax call
  setTimeout(function() {
    // onLoginSuccess();
    onLoginFailed('Username/Password tidak cocok');
  }, 1000);
}

function onLoginSuccess() {
  swal('Success!', 'Berhasil masuk ke SIRIMA!', 'success');
  // window.location = '/'
}

function onLoginFailed(error) {
  swal('Failed!', 'Gagal masuk ke SIRIMA: ' + error, 'error');
  u('#login-button').first().removeAttribute('disabled');
}
