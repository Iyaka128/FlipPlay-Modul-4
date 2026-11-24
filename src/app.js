
const API_URL =
  "https://kitsu.io/api/edge/anime?include=categories&page%5Blimit%5D=20&page%5Boffset%5D=0";

const animeGrid = document.querySelector("#anime-grid");
const loadingMessage = document.querySelector("#loading-message");
const errorMessage = document.querySelector("#error-message");
const searchInput = document.querySelector("#anime-search");
const auraButtons = document.querySelector("#aura-buttons");
const resultCount = document.querySelector("#result-count");
const loadMoreButton = document.querySelector("#load-more");
const menuToggle = document.querySelector("#menu-toggle");
const mainNav = document.querySelector("#main-nav");

const searchForm = document.querySelector("#anime-search-form");
const searchButton = document.querySelector("#anime-search-submit");

let animeList = [];
let activeAura = "all";
let visibleLimit = 24;

const auraRules = {
  all: () => true,

  energy: (anime) =>
    anime.genres.some((genre) =>
      ["action", "sports", "adventure", "comedy"]
        .some((name) => genre.includes(name))
    ),

  melancholy: (anime) =>
    anime.genres.some((genre) =>
      ["drama", "romance", "slice of life"]
        .some((name) => genre.includes(name))
    ),

  binge: (anime) =>
    anime.episodes === null ||
    anime.episodes === undefined ||
    anime.episodes >= 24
};

function showLoading() {
  loadingMessage.hidden = false;
  errorMessage.hidden = true;
  animeGrid.innerHTML = "";
}

function showError(message) {
  loadingMessage.hidden = true;
  errorMessage.hidden = false;
  errorMessage.textContent = message;
}

function renderAnime(items) {
  const html = items.map((anime) => {
    const image = anime.image || "";
    const title = anime.title || "Untitled";
    const score = anime.score !== null
      ? anime.score.toFixed(1)
      : "N/A";
    const episodes = anime.episodes ?? "TBA";
    const genres = anime.genres.slice(0, 2).join(" • ");

    return `
      <article class="anime-card">
        <a class="poster-link"
           href="${anime.url}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Lihat ${title} di Kitsu">
          <img class="anime-poster"
               src="${image}"
               alt="Poster ${title}"
               loading="lazy">
        </a>
        <div class="anime-card-body">
          <div class="anime-meta">
            <span>★ ${score}</span>
            <span>${episodes} eps</span>
          </div>
          <h3>${title}</h3>
          <p class="anime-genres">${genres || "Anime"}</p>
          <a class="detail-link"
             href="${anime.url}"
             target="_blank"
             rel="noopener noreferrer">
            Lihat detail ↗
          </a>
        </div>
      </article>`;
  }).join("");

  animeGrid.innerHTML = html;

  resultCount.textContent = `${items.length} anime ditampilkan`;
  loadMoreButton.hidden = items.length < visibleLimit;
}

function applyFilters() {
  const keyword = searchInput.value.trim().toLowerCase();

  const filteredAnime = animeList.filter((anime) => {
    const matchesTitle =
      anime.title.toLowerCase().includes(keyword);

    const matchesAura = auraRules[activeAura](anime);

    return matchesTitle && matchesAura;
  });

  const visibleAnime = filteredAnime.slice(0, visibleLimit);

  renderAnime(visibleAnime);

  resultCount.textContent =
    `${visibleAnime.length} dari ${filteredAnime.length} anime ditemukan`;

  if (filteredAnime.length === 0) {
    animeGrid.innerHTML =
      '<p class="empty-state">Tidak ada anime yang cocok. Coba kata kunci atau Aura lain.</p>';
  }
}

async function getAnime() {
  showLoading();

  try {
    const response = await fetch(API_URL, {
      headers: {
        Accept: "application/vnd.api+json"
      }
    });

    if (!response.ok) {
      throw new Error(
        `Server merespons HTTP ${response.status} ${response.statusText}`
      );
    }

    const result = await response.json();

    if (!Array.isArray(result.data)) {
      throw new Error("Format data dari Kitsu tidak sesuai.");
    }

    const categoryMap = new Map(
      (result.included || [])
        .filter((item) => item.type === "categories")
        .map((item) => [
          item.id,
          (
            item.attributes?.title ||
            item.attributes?.slug ||
            ""
          ).toLowerCase()
        ])
    );

    animeList = result.data.map((item) => {
      const anime = item.attributes;
      const categoryRelations =
        item.relationships?.categories?.data || [];

      const genres = categoryRelations
        .map((category) => categoryMap.get(category.id))
        .filter(Boolean);

      return {
        id: item.id,
        title: anime.canonicalTitle || "Untitled",
        episodes: anime.episodeCount ?? null,
        score: anime.averageRating
          ? Number(anime.averageRating) / 10
          : null,
        image:
          anime.posterImage?.large ||
          anime.posterImage?.original ||
          "",
        url: `https://kitsu.io/anime/${item.id}`,
        genres
      };
    });

    loadingMessage.hidden = true;
    errorMessage.hidden = true;

    applyFilters();
  } catch (error) {
    console.error("Gagal memuat data Kitsu:", error);
    showError(
      `Gagal memuat data anime. ${error.message}. Periksa koneksi internet dan Console.`
    );
  }
}


searchForm.addEventListener("submit", async (event) => {
  event.preventDefault();

  visibleLimit = 24;
  searchButton.disabled = true;
  searchButton.textContent = "Memuat...";

  try {
    await getAnime();
  } finally {
    searchButton.disabled = false;
    searchButton.textContent = "Search";
  }
});


auraButtons.addEventListener("click", (event) => {
  const button = event.target.closest("button[data-aura]");
  if (!button) return;

  activeAura = button.dataset.aura;

  auraButtons.querySelectorAll("button").forEach((item) => {
    item.classList.toggle("active", item === button);
  });

  visibleLimit = 24;
  applyFilters();
});

loadMoreButton.addEventListener("click", () => {
  visibleLimit += 12;
  applyFilters();
});

menuToggle.addEventListener("click", () => {
  const isExpanded =
    menuToggle.getAttribute("aria-expanded") === "true";

  menuToggle.setAttribute("aria-expanded", String(!isExpanded));
  mainNav.classList.toggle("nav-open", !isExpanded);
});

mainNav.addEventListener("click", (event) => {
  if (event.target.closest("a")) {
    mainNav.classList.remove("nav-open");
    menuToggle.setAttribute("aria-expanded", "false");
  }
});

getAnime();
