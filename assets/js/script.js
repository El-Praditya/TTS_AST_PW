window.addEventListener('load', function () {

  var loadingScreen = document.getElementById('loading-screen');
  var mainContent   = document.getElementById('main-content');
  var title         = document.getElementById('title');
  var subtitle      = document.getElementById('subtitle');

  // ============ TIMELINE ============
  // t=0      : mulai
  // t=2000   : loading fade-out, main fade-in
  // t=2600   : judul muncul penuh di tengah
  // t=3400   : judul mulai "diseret" ke atas (jeda 800ms biar user sempat lihat)
  // t=4300   : subtitle muncul di bawah judul

  var LOADING_DURATION = 1200;
  var HOLD_BEFORE_MOVE = 800;   // jeda sebelum diseret
  var FADE_OUT_DURATION = 600;

  // 1) Setelah 2 detik → hilangkan loading
  setTimeout(function () {
    loadingScreen.classList.add('hide');
    mainContent.classList.add('show');

    setTimeout(function () {
      loadingScreen.style.display = 'none';
      document.body.style.overflow = 'auto';
    }, FADE_OUT_DURATION);

    // 2) Setelah loading fade selesai + jeda → seret judul ke atas
    setTimeout(function () {
      title.classList.add('move-up');

      // 3) Setelah judul sampai atas → munculkan subtitle
      setTimeout(function () {
        subtitle.classList.add('show');
      }, 600); // tunggu animasi judul selesai (0.9s di CSS, tapi 600ms cukup)

    }, FADE_OUT_DURATION + HOLD_BEFORE_MOVE);

  }, LOADING_DURATION);

});