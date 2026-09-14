
document.addEventListener("DOMContentLoaded", () => {

  /* ---------- Thème clair/sombre (persisté) ---------- */
  const themeToggle = document.getElementById("themeToggle");
  const root = document.documentElement;
  const savedTheme = localStorage.getItem("portfolio-theme");
  if (savedTheme === "dark") root.setAttribute("data-theme", "dark");

  themeToggle.addEventListener("click", () => {
    const isDark = root.getAttribute("data-theme") === "dark";
    if (isDark) {
      root.removeAttribute("data-theme");
      localStorage.setItem("portfolio-theme", "light");
    } else {
      root.setAttribute("data-theme", "dark");
      localStorage.setItem("portfolio-theme", "dark");
    }
  });

  /* ---------- Menu mobile ---------- */
  const burger = document.getElementById("navBurger");
  const navLinks = document.getElementById("navLinks");
  burger.addEventListener("click", () => navLinks.classList.toggle("open"));
  navLinks.querySelectorAll("a").forEach(link =>
    link.addEventListener("click", () => navLinks.classList.remove("open"))
  );

  /* ---------- Scroll-spy : surligne le lien de nav actif ---------- */
  const sections = document.querySelectorAll("main section[id]");
  const navItems = document.querySelectorAll(".nav-link");

  const spyObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute("id");
          navItems.forEach((link) => {
            link.classList.toggle("active", link.getAttribute("href") === `#${id}`);
          });
        }
      });
    },
    { rootMargin: "-40% 0px -50% 0px", threshold: 0 }
  );
  sections.forEach((s) => spyObserver.observe(s));

  /* ---------- Animation "reveal" au scroll ---------- */
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );
  document.querySelectorAll(".reveal").forEach((el) => revealObserver.observe(el));

  /* ---------- Modal vidéo (projet H2SI Hub) ---------- */
  const modal = document.getElementById("videoModal");
  const modalMedia = modal.querySelector(".modal-media");
  const modalClose = document.getElementById("modalClose");

  document.querySelectorAll("[data-video]").forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      e.preventDefault();
      const src = trigger.dataset.video;
      modalMedia.innerHTML = `<video controls autoplay src="${src}"></video>`;
      modal.classList.add("open");
    });
  });

  function closeModal() {
    modal.classList.remove("open");
    modalMedia.innerHTML = "";
  }
  modalClose.addEventListener("click", closeModal);
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModal();
  });

});
