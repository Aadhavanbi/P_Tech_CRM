"use strict";

(function ($) {
  $(document).ready(function () {
    $("#saveInvoice").click(function () {
      console.log("Saving Invoice...");

      // Collect invoice details
      let invoiceData = {
        client_id: $("#client_id").val().trim(),
        invoice_date: $("#invoice_date").val(),
        due_date: $("#due_date").val(),
        sub_total:
          parseFloat($("#subtotal_amount").text().trim().replace("$", "")) || 0,
        discount: parseFloat($("#discount_input").val().trim()) || 0,
        tax: parseFloat($("td:contains('Tax:') + td span").text().trim()) || 0,
        total_amount:
          parseFloat($("#total_amount").text().trim().replace("$", "")) || 0,
        items: [],
      };

      // Collect invoice items with description
      $(".invoice-body tr:not(.description-row)").each(function () {
        let row = $(this);
        let rowClass = row.attr("class"); // Get row class to find the description row

        let item = {
          item_name: row.find('[data-name="item_name"]').val().trim(),
          item_qty:
            parseInt(row.find('[data-name="item_qty"]').val().trim()) || 0,
          item_units: row.find('[data-name="item_units"]').val().trim(),
          item_price:
            parseFloat(row.find('[data-name="item_price"]').val().trim()) || 0,
          item_total:
            parseFloat(row.find('[data-name="item_total"]').val().trim()) || 0,
          item_description:
            $(`.${rowClass}.description-row textarea`).val() || "", // Find corresponding description row
        };

        invoiceData.items.push(item);
      });

      console.log(invoiceData); // Debugging in console

      $.ajax({
        url: $("#base_url").val() + "invoice_save",
        type: "POST",
        data: JSON.stringify(invoiceData),
        contentType: "application/json",
        success: function (response) {
          console.log(response);
          if (response.success) {
            alert("Invoice Saved Successfully!");
            window.location.href = $("#base_url").val() + "invoice"; // Redirect to invoice list
          } else {
            alert("Error saving invoice: " + response.message);
          }
        },
        error: function (xhr) {
          alert("AJAX request failed! Status: " + xhr.status);
        },
      });
    });
  });

  $(document).ready(function () {
    $("#addRow").click(function () {
      console.log("add row clicked");

      const rowCount = $(".invoice-body tr").length / 2 + 1; // Count only item rows
      const itemRow = `
            <tr class="invoice_body_${rowCount}">
                <td>${String(rowCount).padStart(2, "0")}</td>
                <td><input type="text" class="form-control" data-name="item_name" value="New Item"></td>
                <td><input type="number" class="form-control" data-name="item_qty" value="1"></td>
                <td><input type="text" class="form-control" data-name="item_units" value="PC"></td>
                <td><input type="number" class="form-control" data-name="item_price" value="0.00" step="0.01"></td>
                <td><input type="number" class="form-control" data-name="item_total" value="0.00" step="0.01"></td>
                <td class="text-center">
                    <button type="button" class="remove-row">
                        <iconify-icon icon="ic:twotone-close" class="text-danger-600 text-xl"></iconify-icon>
                    </button>
                </td>
            </tr>
            <tr class="description-row invoice_body_${rowCount}">
                <td colspan="7">
                    <textarea class="form-control" data-name="item_description" placeholder="Enter description..."></textarea>
                </td>
            </tr>
        `;
      $(".invoice-body").append(itemRow);
    });

    $(document).on("click", ".remove-row", function () {
      const row = $(this).closest("tr");
      const rowClass = row.attr("class");
      row.next(`.description-row.${rowClass}`).remove(); // Remove description row
      row.remove(); // Remove item row
      updateRowNumbers();
    });

    function updateRowNumbers() {
      $(".invoice-body tr:not(.description-row)").each(function (index) {
        $(this)
          .find("td:first")
          .text(String(index + 1).padStart(2, "0"));
        $(this).attr("class", `invoice_body_${index + 1}`);
        $(this)
          .next(".description-row")
          .attr("class", `description-row invoice_body_${index + 1}`);
      });
    }
  });

  $(document).ready(function () {
    $("#invoice-form").submit(function (e) {
      e.preventDefault(); // Prevent default form submission

      let invoiceID = $("#invoice-form").attr("action").split("/").pop(); // Get invoice ID from action URL
      let isUpdate = invoiceID !== "add"; // Check if it's an update

      let invoiceData = {
        client_id: $("#client_id").val().trim(),
        invoice_date: $("#invoice_date").val().trim(),
        due_date: $("#due_date").val().trim(),
        sub_total:
          parseFloat($("#subtotal_amount").text().trim().replace("$", "")) || 0,
        discount: parseFloat($("#discount_input").val().trim()) || 0, // Fix here: should use .val() instead of .text()
        tax: parseFloat($("td:contains('Tax:') + td span").text().trim()) || 0,
        total_amount:
          parseFloat($("#total_amount").text().trim().replace("$", "")) || 0,
        items: [],
      };

      // Collect invoice items with descriptions
      $("#invoice-body tr:not(.description-row)").each(function () {
        let row = $(this);
        let nextRow = row.next(".description-row"); // Get the next row which is the description row

        let item = {
          item_name: row.find('[name*="[name]"]').val().trim(),
          item_qty:
            parseInt(row.find('[name*="[quantity]"]').val().trim()) || 0,
          item_units: row.find('[name*="[unit]"]').val().trim(),
          item_price:
            parseFloat(row.find('[name*="[unit_price]"]').val().trim()) || 0,
          item_total:
            parseFloat(row.find('[name*="[total_price]"]').val().trim()) || 0,
          item_description: nextRow.find("textarea").val().trim() || "", // Fix: Find the description row properly
        };

        invoiceData.items.push(item);
      });

      console.log(invoiceData);

      $.ajax({
        url: isUpdate
          ? $("#base_url").val() + "invoice_update/" + invoiceID
          : $("#base_url").val() + "invoice_create",
        type: "POST",
        data: JSON.stringify(invoiceData),
        contentType: "application/json",
        success: function (response) {
          console.log(response);
          if (response.success) {
            alert(
              isUpdate
                ? "Invoice Updated Successfully!"
                : "Invoice Saved Successfully!"
            );
            window.location.href = $("#base_url").val() + "invoice"; // Redirect to invoice list
          } else {
            alert("Error: " + response.message);
          }
        },
        error: function (xhr) {
          alert("AJAX request failed! Status: " + xhr.status);
        },
      });
    });
  });

  // Make table cells editable on click
  $(".editable").click(function () {
    const cell = $(this);
    const originalText = cell.text().substring(1); // Remove the leading ':'
    const input = $('<input type="text" class="form-control" />').val(
      originalText
    );

    cell.empty().append(input);

    input.focus().select();

    input.blur(function () {
      const newText = input.val();
      cell.text(" " + newText);
    });

    input.keypress(function (e) {
      if (e.which == 13) {
        // Enter key
        const newText = input.val();
        cell.text(":" + newText);
      }
    });
  });
  document.addEventListener("DOMContentLoaded", function () {
    function makeEditable(span) {
      let originalText = span.innerText.trim();
      let input = document.createElement("input");
      input.type = "text";
      input.value = originalText !== "-" ? originalText : "";
      input.className = "form-control";
      input.style.width = "auto";

      // Replace span with input
      span.replaceWith(input);
      input.focus();

      // When the user leaves the field
      input.addEventListener("blur", function () {
        let newValue = input.value.trim();
        if (newValue === "") {
          newValue = "-"; // Reset to placeholder
        }
        let newSpan = document.createElement("span");
        newSpan.id = span.id;
        newSpan.className = span.className;
        newSpan.innerText = newValue;
        newSpan.addEventListener("click", function () {
          makeEditable(newSpan);
        });

        // Replace input with updated span
        input.replaceWith(newSpan);
      });

      // Handle Enter key (Save)
      input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
          input.blur();
        }
      });
    }

    // Apply to all editable spans
    document.querySelectorAll(".editable").forEach(function (span) {
      span.addEventListener("click", function () {
        makeEditable(span);
      });
    });
  });

  $(document).on(
    "input",
    '[data-name="item_qty"], [data-name="item_price"]',
    function () {
      updateInvoiceTotals();
    }
  );

  function updateInvoiceTotals() {
    let subtotal = 0;

    $(".invoice-body tr").each(function () {
      let qty = parseFloat($(this).find('[data-name="item_qty"]').val()) || 0;
      let price =
        parseFloat($(this).find('[data-name="item_price"]').val()) || 0;
      let total = qty * price;

      $(this).find('[data-name="item_total"]').val(total.toFixed(2));

      subtotal += total;
    });

    // Update subtotal
    $("#subtotal_amount").text(`$${subtotal.toFixed(2)}`);

    // Get discount and update total
    let discount =
      parseFloat($("#discount_amount").text().replace("$", "")) || 0;
    let finalTotal = subtotal - discount;
    $("#total_amount").text(`$${finalTotal.toFixed(2)}`);
  }
  $(document).on("input", "#discount_input", function () {
    let discount = parseFloat($(this).val()) || 0;
    $("#discount_amount").text(`$${discount.toFixed(2)}`);
    updateInvoiceTotals();
  });
  $(document).ready(function () {
    updateInvoiceTotals();
  });

  function deleteInvoice(invoiceId) {
    if (confirm("Are you sure you want to delete this invoice?")) {
      window.location.href = "<?= base_url('invoice/delete/') ?>" + invoiceId;
    }
  }
  $(document).ready(function () {
    // Get today's date
    let today = new Date();

    // Format date as YYYY-MM-DD
    let todayFormatted = today.toISOString().split("T")[0];

    // Set issue date as today
    $("#invoice_date").val(todayFormatted);

    // Calculate due date (today + 5 days)
    let dueDate = new Date();
    dueDate.setDate(dueDate.getDate() + 5);
    let dueDateFormatted = dueDate.toISOString().split("T")[0];

    // Set due date
    $(".date-input").eq(1).val(dueDateFormatted);
  });

  document.addEventListener("DOMContentLoaded", function () {
    // Get today's date
    let today = new Date();
    let todayFormatted = today.toISOString().split("T")[0];

    // Set initial values
    let issueDateInput = document.getElementById("invoice_date");
    let displayIssueDate = document.getElementById("display_issue_date");

    // Function to format date as "25 Jan 2025"
    function formatDateString(dateStr) {
      let dateObj = new Date(dateStr);
      let options = { day: "2-digit", month: "short", year: "numeric" };
      return dateObj.toLocaleDateString("en-GB", options);
    }

    // Set default issue date
    issueDateInput.value = todayFormatted;

    displayIssueDate.textContent = formatDateString(todayFormatted);

    // Update displayed issue date when input changes
    issueDateInput.addEventListener("change", function () {
      displayIssueDate.textContent = formatDateString(issueDateInput.value);
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
    window.fetchClientDetails = function () {
      let clientSelect = document.getElementById("client_id");
      let selectedOption = clientSelect.options[clientSelect.selectedIndex];

      let address = selectedOption.getAttribute("data-address") || "-";
      let phone = selectedOption.getAttribute("data-phone") || "-";

      document.getElementById("client_address").innerText = address;
      document.getElementById("client_phone").innerText = phone;
    };

    // Call function on page load
    fetchClientDetails();

    // Call function when client selection changes
    document
      .getElementById("client_id")
      .addEventListener("change", fetchClientDetails);
  });
})(jQuery);

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".icon-field input");
  const tableRows = document.querySelectorAll(".table tbody tr");

  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      let filter = searchInput.value.toLowerCase();

      tableRows.forEach((row) => {
        let invoice =
          row.querySelector("td:nth-child(2) a")?.textContent.toLowerCase() ||
          "";
        let name =
          row.querySelector("td:nth-child(3) h6")?.textContent.toLowerCase() ||
          "";
        let date =
          row.querySelector("td:nth-child(4)")?.textContent.toLowerCase() || "";
        let amount =
          row.querySelector("td:nth-child(5)")?.textContent.toLowerCase() || "";

        if (
          invoice.includes(filter) ||
          name.includes(filter) ||
          date.includes(filter) ||
          amount.includes(filter)
        ) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  }
});

function printInvoice() {
  let printContents = document.getElementById("invoice").innerHTML;
  let originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload(); // Reload to restore the original layout
}

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".icon-field input");
  const tableBody = document.querySelector(".table tbody");
  const tableRows = Array.from(tableBody.querySelectorAll("tr"));
  const showEntriesSelect = document.querySelector(".form-select");
  const showingText = document.querySelector("#showingText");
  const paginationContainer = document.querySelector(".pagination");

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
              <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                  href="javascript:void(0)" data-page="${currentPage - 1}">
                  <iconify-icon icon="ep:d-arrow-left" class="text-xl"></iconify-icon>
              </a>
          </li>
      `;

    // Page Number Buttons
    for (let i = 1; i <= totalPages; i++) {
      paginationHTML += `
              <li class="page-item">
                  <a class="page-link ${
                    i === currentPage
                      ? "bg-primary-600 text-white"
                      : "bg-primary-50 dark:bg-primary-600/25 text-secondary-light"
                  } font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8"
                      href="javascript:void(0)" data-page="${i}">${i}</a>
              </li>
          `;
    }

    // Next Button
    paginationHTML += `
          <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
              <a class="page-link text-secondary-light font-medium rounded border-0 px-2.5 py-2.5 flex items-center justify-center h-8 w-8 bg-white dark:bg-neutral-700"
                  href="javascript:void(0)" data-page="${currentPage + 1}">
                  <iconify-icon icon="ep:d-arrow-right" class="text-xl"></iconify-icon>
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
      let invoice =
        row.querySelector("td:nth-child(2) a")?.textContent.toLowerCase() || "";
      let name =
        row.querySelector("td:nth-child(3) h6")?.textContent.toLowerCase() ||
        "";
      let date =
        row.querySelector("td:nth-child(4)")?.textContent.toLowerCase() || "";
      let amount =
        row.querySelector("td:nth-child(5)")?.textContent.toLowerCase() || "";

      return (
        invoice.includes(filter) ||
        name.includes(filter) ||
        date.includes(filter) ||
        amount.includes(filter)
      );
    });

    currentPage = 1; // Reset to first page after filtering
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

  showEntriesSelect.addEventListener("change", function () {
    rowsPerPage = parseInt(this.value);
    currentPage = 1; // Reset to first page when changing entries per page
    paginateRows();
  });

  if (searchInput) {
    searchInput.addEventListener("keyup", filterRows);
  }

  paginateRows(); // Initial load
});

document.addEventListener("DOMContentLoaded", function () {
  const statusFilter = document.getElementById("filterStatus");

  statusFilter.addEventListener("change", function () {
    const selectedStatus = this.value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row) => {
      const statusCell = row.querySelector("td:nth-child(6) span"); // 6th column (Status)
      if (statusCell) {
        const statusText = statusCell.textContent.trim().toLowerCase();
        if (selectedStatus === "" || statusText === selectedStatus) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      }
    });
  });
});
