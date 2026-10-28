(() => {
  const root = document.documentElement;
  const media = matchMedia('(prefers-color-scheme: dark)');
  const toggle = document.querySelector('.theme-toggle');
  const readPreference = () => {
    try { return localStorage.getItem('theme'); } catch (_) { return null; }
  };
  let preference = readPreference();
  const applyTheme = () => {
    const theme = ['light', 'dark'].includes(preference) ? preference : media.matches ? 'dark' : 'light';
    root.dataset.theme = theme;
    document.querySelector('meta[name="theme-color"]').content = theme === 'dark' ? '#181818' : '#fafafa';
    toggle.querySelector('span').textContent = theme === 'dark' ? '☀︎' : '☾';
    toggle.setAttribute('aria-label', theme === 'dark' ? 'Включить светлую тему' : 'Включить тёмную тему');
  };
  applyTheme();
  toggle.hidden = false;
  toggle.addEventListener('click', () => {
    preference = root.dataset.theme === 'dark' ? 'light' : 'dark';
    try { localStorage.setItem('theme', preference); } catch (_) {}
    applyTheme();
  });
  media.addEventListener('change', applyTheme);
  window.addEventListener('storage', event => {
    if (event.key === 'theme' || event.key === null) {
      preference = readPreference();
      applyTheme();
    }
  });

  const menu = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.site-nav');
  menu.hidden = false;
  const closeMenu = () => {
    nav.classList.remove('is-open');
    menu.setAttribute('aria-expanded', 'false');
    menu.setAttribute('aria-label', 'Открыть меню');
  };
  menu.addEventListener('click', () => {
    const open = nav.classList.toggle('is-open');
    menu.setAttribute('aria-expanded', String(open));
    menu.setAttribute('aria-label', open ? 'Закрыть меню' : 'Открыть меню');
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && nav.classList.contains('is-open')) {
      closeMenu();
      menu.focus();
    }
  });

  const toc = document.querySelector('.post-sidebar .toc');
  if (toc) {
    const desktop = matchMedia('(min-width: 1100px)');
    const expandTOC = () => { toc.open = desktop.matches; };
    expandTOC();
    desktop.addEventListener('change', expandTOC);
    const links = [...toc.querySelectorAll('a[href^="#"]')];
    const headings = links.map(link => document.getElementById(decodeURIComponent(link.hash.slice(1)))).filter(Boolean);
    const updateTOC = () => {
      const active = [...headings].reverse().find(heading => heading.getBoundingClientRect().top <= 120) || headings[0];
      links.forEach(link => {
        if (active && decodeURIComponent(link.hash.slice(1)) === active.id) link.setAttribute('aria-current', 'location');
        else link.removeAttribute('aria-current');
      });
    };
    let scheduled = false;
    const scheduleTOC = () => {
      if (scheduled) return;
      scheduled = true;
      requestAnimationFrame(() => { updateTOC(); scheduled = false; });
    };
    window.addEventListener('scroll', scheduleTOC, {passive: true});
    window.addEventListener('hashchange', scheduleTOC);
    window.addEventListener('resize', scheduleTOC);
    updateTOC();
  }

  const copy = async (button, text, label) => {
    try {
      await navigator.clipboard.writeText(text);
      button.textContent = 'Скопировано';
    } catch (_) {
      button.textContent = 'Не удалось скопировать';
    }
    setTimeout(() => { button.textContent = label; }, 2000);
  };
  document.querySelectorAll('.prose .highlight, .prose pre').forEach(block => {
    if (block.tagName === 'PRE' && block.closest('.highlight')) return;
    const code = block.querySelector('code[data-lang]') || block.querySelector('td:last-child code') || block.querySelector('code');
    if (!code) return;
    const wrapper = document.createElement('div');
    wrapper.className = 'code-block';
    block.before(wrapper);
    wrapper.append(block);
    block.tabIndex = 0;
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'copy-code';
    button.textContent = 'Копировать';
    button.setAttribute('aria-live', 'polite');
    button.addEventListener('click', () => {
      const clean = code.cloneNode(true);
      clean.querySelectorAll('.ln, .lnt').forEach(number => number.remove());
      copy(button, clean.textContent, 'Копировать');
    });
    wrapper.append(button);
  });
  const copyLink = document.querySelector('.copy-link');
  if (copyLink) {
    copyLink.hidden = false;
    copyLink.setAttribute('aria-live', 'polite');
    copyLink.addEventListener('click', () => copy(copyLink, document.querySelector('link[rel="canonical"]').href, 'Скопировать ссылку ↗'));
  }

  document.querySelectorAll('.prose iframe').forEach(frame => {
    if (/youtube(?:-nocookie)?\.com|player\.vimeo\.com/.test(frame.src)) {
      const width = Number(frame.getAttribute('width'));
      const height = Number(frame.getAttribute('height'));
      if (width > 0 && height > 0) frame.style.setProperty('--video-ratio', `${width} / ${height}`);
      if (!frame.title) frame.title = 'Видеоплеер';
    } else if (!frame.title) {
      frame.title = 'Встроенный медиаплеер';
    }
    frame.loading = 'lazy';
  });

  const viewer = document.querySelector('.image-viewer');
  if (typeof viewer.showModal === 'function') {
    let source;
    document.querySelectorAll('.prose img, .hero-image img').forEach(img => {
      if (img.closest('a')) return;
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'image-zoom';
      button.setAttribute('aria-label', img.alt ? `Увеличить: ${img.alt}` : 'Увеличить изображение');
      img.before(button);
      button.append(img);
      button.addEventListener('click', () => {
        source = button;
        const full = viewer.querySelector('img');
        full.src = img.currentSrc || img.src;
        full.alt = img.alt;
        viewer.showModal();
      });
    });
    viewer.querySelector('button').addEventListener('click', () => viewer.close());
    viewer.addEventListener('click', event => {
      if (event.target === viewer) viewer.close();
    });
    viewer.addEventListener('close', () => { if (source) source.focus(); });
  }
})();
