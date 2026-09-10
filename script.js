document.addEventListener('DOMContentLoaded', () => {
  const loginBtn = document.getElementById('loginBtn');
  const loginDropdown = document.getElementById('loginDropdown');
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');

  // Toggle Login Dropdown
  loginBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    loginDropdown.classList.toggle('show');
    const chevron = loginBtn.querySelector('.chevron');
    if (chevron) {
      chevron.style.transform = loginDropdown.classList.contains('show') 
        ? 'rotate(180deg)' 
        : 'rotate(0)';
    }
  });

  // Close dropdown on outside click
  document.addEventListener('click', (e) => {
    if (!loginDropdown.contains(e.target) && !loginBtn.contains(e.target)) {
      loginDropdown.classList.remove('show');
      const chevron = loginBtn.querySelector('.chevron');
      if (chevron) chevron.style.transform = 'rotate(0)';
    }
  });

  // Quick Search Action
  searchBtn.addEventListener('click', () => {
    const query = searchInput.value.trim();
    if (query) {
      alert(`Searching for listings matching: "${query}"`);
    } else {
      searchInput.focus();
    }
  });

  searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      searchBtn.click();
    }
  });
});