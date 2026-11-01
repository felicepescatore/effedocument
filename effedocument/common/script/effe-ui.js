/* eFFe Document 1.5.0 - comportamenti dell'interfaccia (menu su mobile, tabelle scorrevoli) */
(function () {
  function pronto(fn) {
    if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn);
  }
  pronto(function () {
    // Menu su schermi piccoli
    var bar = document.querySelector('.appbar');
    var btn = document.querySelector('.nav-toggle');
    if (bar && btn) {
      btn.addEventListener('click', function () {
        var aperto = bar.classList.toggle('aperta');
        btn.setAttribute('aria-expanded', aperto ? 'true' : 'false');
      });
    }
    // Le tabelle di dati scorrono in orizzontale invece di allargare la pagina
    var tabelle = Array.prototype.slice.call(document.querySelectorAll('table[border="1"], table.dati'));
    var vecchie = document.querySelectorAll('tr[style*="bgfooter"]');
    for (var v = 0; v < vecchie.length; v++) {
      var tab = vecchie[v].closest('table');
      if (tab && tabelle.indexOf(tab) === -1) tabelle.push(tab);
    }
    for (var i = 0; i < tabelle.length; i++) {
      var t = tabelle[i];
      if (t.parentNode.classList && t.parentNode.classList.contains('scroll-tabella')) continue;
      var box = document.createElement('div');
      box.className = 'scroll-tabella';
      t.parentNode.insertBefore(box, t);
      box.appendChild(t);
    }
  });
})();
