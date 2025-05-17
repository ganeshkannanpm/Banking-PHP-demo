const allTabBtn = document.querySelector('[data-bs-target="#all"]');
const allContainer = document.getElementById('all-container');

// Prevent duplicate appending
let isAllTabLoaded = false;

allTabBtn.addEventListener('click', function () {
  if (!isAllTabLoaded) {
    allContainer.innerHTML = ''; // Clear old content

    // Loop through all panes except 'all'
    document.querySelectorAll('#services-tabs-content .tab-pane').forEach(pane => {
      if (pane.id !== 'all') {
        pane.querySelectorAll('.col').forEach(cardCol => {
          allContainer.appendChild(cardCol.cloneNode(true));
        });
      }
    });

    isAllTabLoaded = true; // Mark as loaded
  }
});

// Optional: load All tab if visible on page load
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('#all').classList.contains('show')) {
    allTabBtn.click();
  }
});

