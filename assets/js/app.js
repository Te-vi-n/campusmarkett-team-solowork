document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('#q');
  const categorySelect = document.querySelector('#category');

  if (searchInput && categorySelect && window.fetch) {
    fetch('products-json.php')
      .then((res) => (res.ok ? res.json() : null))
      .then((items) => {
        if (Array.isArray(items)) {
          searchInput.dataset.totalCatalogItems = String(items.length);
        }
      })
      .catch(() => {});
  }
});