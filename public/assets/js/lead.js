document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".icon-field input");
  const tableBody = document.querySelector(".table tbody");
  const tableRows = Array.from(tableBody.querySelectorAll("tr"));
  const showEntriesSelect = document.querySelector(".form-select");
  const showingText = document.querySelector("#showingText");
  const paginationContainer = document.querySelector(".pagination");
  // const statusFilter = document.getElementById("filterStatus");

  let rowsPerPage = parseInt(showEntriesSelect.value);
  let filteredRows = [...tableRows]; // Holds currently filtered rows
  let currentPage = 1;

  function updateShowingText(start, end, total) {
    if (total === 0) {
      showingText.textContent = "Showing 0 of 0 entries";
    } else {
      showingText.textContent = `Showing ${start} to ${end} of ${total} entries`;
    }
  }

  function generatePaginationButtons() {
    paginationContainer.innerHTML = ""; // Clear previous pagination
    let totalPages = Math.ceil(filteredRows.length / rowsPerPage);

    if (totalPages <= 1) return; // No pagination needed if only 1 page

    let paginationHTML = "";

    // Previous Button
    paginationHTML += `
            <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="javascript:void(0)" data-page="${
                  currentPage - 1
                }">
                    <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
                </a>
            </li>
        `;

    // Page Number Buttons
    for (let i = 1; i <= totalPages; i++) {
      paginationHTML += `
                <li class="page-item">
                    <a class="page-link ${
                      i === currentPage ? "active" : ""
                    }" href="javascript:void(0)" data-page="${i}">${i}</a>
                </li>
            `;
    }

    // Next Button
    paginationHTML += `
            <li class="page-item ${
              currentPage === totalPages ? "disabled" : ""
            }">
                <a class="page-link" href="javascript:void(0)" data-page="${
                  currentPage + 1
                }">
                    <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
                </a>
            </li>
        `;

    paginationContainer.innerHTML = paginationHTML;

    // Add event listeners to pagination buttons
    paginationContainer.querySelectorAll("a[data-page]").forEach((button) => {
      button.addEventListener("click", function () {
        let page = parseInt(this.getAttribute("data-page"));
        if (page > 0 && page <= totalPages) {
          currentPage = page;
          paginateRows();
        }
      });
    });
  }

  function filterRows() {
    let filter = searchInput.value.toLowerCase();
    filteredRows = tableRows.filter((row) => {
      let leadId =
        row.querySelector("td:nth-child(2) a")?.textContent.toLowerCase() || "";
      let name =
        row.querySelector("td:nth-child(3)")?.textContent.toLowerCase() || "";
      let stage =
        row.querySelector("td:nth-child(4) span")?.textContent.toLowerCase() ||
        "";
      let date =
        row.querySelector("td:nth-child(5)")?.textContent.toLowerCase() || "";

      return (
        leadId.includes(filter) ||
        name.includes(filter) ||
        stage.includes(filter) ||
        date.includes(filter)
      );
    });

    currentPage = 1; // Reset to first page after filtering
    paginateRows();
  }

  function filterByStatus() {
    let selectedStatus = statusFilter.value.toLowerCase();
    filteredRows = tableRows.filter((row) => {
      let statusCell = row.querySelector("td:nth-child(6) span");
      if (statusCell) {
        let statusText = statusCell.textContent.trim().toLowerCase();
        return selectedStatus === "" || statusText === selectedStatus;
      }
      return false;
    });

    currentPage = 1; // Reset pagination
    paginateRows();
  }

  function paginateRows() {
    let start = (currentPage - 1) * rowsPerPage;
    let end = Math.min(start + rowsPerPage, filteredRows.length);

    tableRows.forEach((row) => (row.style.display = "none")); // Hide all rows
    filteredRows.slice(start, end).forEach((row) => (row.style.display = "")); // Show only current page rows

    updateShowingText(start + 1, end, filteredRows.length);
    generatePaginationButtons();
  }

  // Event Listeners
  showEntriesSelect.addEventListener("change", function () {
    rowsPerPage = parseInt(this.value);
    currentPage = 1; // Reset pagination
    paginateRows();
  });

  // searchInput.addEventListener("keyup", filterRows);
  // statusFilter.addEventListener("change", filterByStatus);

  paginateRows(); // Initial load
});

document.addEventListener("DOMContentLoaded", function () {
  const statusModal = document.getElementById("statusModal");
  const stageModal = document.getElementById("stageModal");
  const leadIdInput = document.getElementById("leadId");
  const leadIdStageInput = document.getElementById("leadIdStage");
  const newStatusSelect = document.getElementById("newStatus");
  const newStageSelect = document.getElementById("newStage");
  const saveStatusBtn = document.getElementById("saveStatusBtn");
  const saveStageBtn = document.getElementById("saveStageBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const cancelStageBtn = document.getElementById("cancelStageBtn");
  const mainContent = document.querySelector(".test_for_blur");

  // Open Status Modal
  document.querySelectorAll(".update-status").forEach((badge) => {
    badge.addEventListener("click", function () {
      let leadId = this.getAttribute("data-id");
      let currentStatus = this.getAttribute("data-status");

      leadIdInput.value = leadId;
      newStatusSelect.value = currentStatus;

      mainContent.classList.add("blur-bg");
      statusModal.classList.remove("hidden");
    });
  });

  // Open Stage Modal
  document.querySelectorAll(".update-stage").forEach((badge) => {
    badge.addEventListener("click", function () {
      let leadId = this.getAttribute("data-id");
      let currentStage = this.getAttribute("data-stage");

      leadIdStageInput.value = leadId;
      newStageSelect.value = currentStage;

      mainContent.classList.add("blur-bg");
      stageModal.classList.remove("hidden");
    });
  });

  // Close Modals
  function closeModal(modal) {
    modal.classList.add("hidden");
    mainContent.classList.remove("blur-bg");
  }
  cancelBtn.addEventListener("click", () => closeModal(statusModal));
  cancelStageBtn.addEventListener("click", () => closeModal(stageModal));

  saveStatusBtn.addEventListener("click", function () {
    let leadId = leadIdInput.value;
    let newStatus = newStatusSelect.value;

    fetch($("#base_url").val() + "lead_update_status", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({ lead_id: leadId, status: newStatus }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          let badge = document.querySelector(
            `.update-status[data-id="${leadId}"]`
          );
          badge.textContent = newStatus;
          badge.setAttribute("data-status", newStatus);

          // Remove old classes
          badge.className =
            "update-status px-6 py-1.5 rounded-full font-medium text-sm cursor-pointer";

          // Add new class based on status
          switch (newStatus) {
            case "New":
              badge.classList.add(
                "bg-warning-100",
                "dark:bg-warning-600/25",
                "text-warning-600",
                "dark:text-warning-400"
              );
              break;
            case "Contacted":
              badge.classList.add(
                "bg-info-100",
                "dark:bg-info-600/25",
                "text-info-600",
                "dark:text-info-400"
              );
              break;
            case "Converted":
              badge.classList.add(
                "bg-success-100",
                "dark:bg-success-600/25",
                "text-success-600",
                "dark:text-success-400"
              );
              break;
            default:
              badge.classList.add(
                "bg-gray-100",
                "dark:bg-gray-600/25",
                "text-gray-600",
                "dark:text-gray-400"
              );
              break;
          }

          closeModal(statusModal);
        } else {
          alert("Error updating status. Try again.");
        }
      })
      .catch((error) => console.error("Error:", error));
  });

  // Save Stage via AJAX
  saveStageBtn.addEventListener("click", function () {
    let leadId = leadIdStageInput.value;
    let newStage = newStageSelect.value;

    fetch($("#base_url").val() + "lead_update_stage", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({ lead_id: leadId, stage: newStage }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          let badge = document.querySelector(
            `.update-stage[data-id="${leadId}"]`
          );
          badge.textContent = newStage;
          badge.setAttribute("data-stage", newStage);

          // Remove old classes
          badge.className =
            "update-stage px-6 py-1.5 rounded-full font-medium text-sm cursor-pointer";

          // Add new class based on stage
          switch (newStage) {
            case "Prospect":
              badge.classList.add(
                "bg-primary-100",
                "dark:bg-primary-600/25",
                "text-primary-600",
                "dark:text-primary-400"
              );
              break;
            case "Negotiation":
              badge.classList.add(
                "bg-warning-100",
                "dark:bg-warning-600/25",
                "text-warning-600",
                "dark:text-warning-400"
              );
              break;
            case "Proposal Sent":
              badge.classList.add(
                "bg-info-100",
                "dark:bg-info-600/25",
                "text-info-600",
                "dark:text-info-400"
              );
              break;
            case "Won":
              badge.classList.add(
                "bg-success-100",
                "dark:bg-success-600/25",
                "text-success-600",
                "dark:text-success-400"
              );
              break;
            case "Lost":
              badge.classList.add(
                "bg-danger-100",
                "dark:bg-danger-600/25",
                "text-danger-600",
                "dark:text-danger-400"
              );
              break;
            default:
              badge.classList.add(
                "bg-gray-100",
                "dark:bg-gray-600/25",
                "text-gray-600",
                "dark:text-gray-400"
              );
              break;
          }

          closeModal(stageModal);
        } else {
          alert("Error updating stage. Try again.");
        }
      })
      .catch((error) => console.error("Error:", error));
  });

  // Filter Leads by Status & Stage
  function filterLeads() {
    let selectedStatus = document.getElementById("filterStatus").value;
    let selectedStage = document.getElementById("filterStage").value;

    document.querySelectorAll("#leadTableBody tr").forEach((row) => {
      let rowStatus = row.getAttribute("data-status");
      let rowStage = row
        .querySelector(".update-stage")
        ?.getAttribute("data-stage");

      if (
        (selectedStatus === "" || rowStatus === selectedStatus) &&
        (selectedStage === "" || rowStage === selectedStage)
      ) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  document
    .getElementById("filterStatus")
    .addEventListener("change", filterLeads);
  document
    .getElementById("filterStage")
    .addEventListener("change", filterLeads);
});

document.getElementById('searchFollowUpDateBtn').addEventListener('click', function() {
    let selectedDate = document.getElementById('filterFollowUpDate').value; // Get selected date
    let tableRows = document.querySelectorAll('#leadTableBody tr');

    tableRows.forEach(row => {
        let fullFollowUpDate = row.children[3].textContent.trim(); // Get full date from table
        let rowDateOnly = fullFollowUpDate.split(' ')[0]; // Extract YYYY-MM-DD part

        if (selectedDate === "" || rowDateOnly === selectedDate) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// Clear button functionality
document.getElementById('clearFollowUpDateBtn').addEventListener('click', function() {
    document.getElementById('filterFollowUpDate').value = ""; // Reset input field
    let tableRows = document.querySelectorAll('#leadTableBody tr');

    tableRows.forEach(row => {
        row.style.display = ""; // Show all rows again
    });
});
