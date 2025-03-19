function calculateTotal() {
    let subtotal = 0;
    
    document.querySelectorAll("#quote-body tr").forEach((row) => {
        console.log(row.querySelector(".item_qty"));
        
        let qty = row.querySelector(".item_qty").value || 0;
        let price = row.querySelector(".item_price").value || 0;
        let totalField = row.querySelector(".item_total");

        let total = parseFloat(qty) * parseFloat(price);
        totalField.value = total.toFixed(2);
        subtotal += total;
    });

    document.getElementById("subtotal_amount").innerText = "$" + subtotal.toFixed(2);
    
    let discount = parseFloat(document.getElementById("discount_input").value) || 0;
    let totalAmount = subtotal - discount;
    document.getElementById("total_amount").innerText = "$" + totalAmount.toFixed(2);
}

document.getElementById("discount_input").addEventListener("input", calculateTotal);



// Remove row function
function removeRow(button) {
    button.closest("tr").remove();
    calculateTotal();
}



"use strict";

(function ($) {
  $(document).ready(function () {
    $("#saveQuote").click(function () {
      console.log("Saving Quote...");

      // Collect quote details
      let quoteData = {
        client_id: $("#client_id").val().trim(),
        quote_date: $("#quote_date").val(),
        expiration_date: $("#expiration_date").val(),
        sub_total:
          parseFloat($("#subtotal_amount").text().trim().replace("$", "")) || 0,
        discount: parseFloat($("#discount_input").val().trim()) || 0,
        tax: parseFloat($("td:contains('Tax:') + td span").text().trim()) || 0,
        total_amount:
          parseFloat($("#total_amount").text().trim().replace("$", "")) || 0,
        items: [],
      };

      // Collect quote items with descriptions
      $(".quote-body tr:not(.description-row)").each(function () {
        let row = $(this);
        let rowClass = row.attr("class");

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
            $(`.${rowClass}.description-row textarea`).val() || "",
        };

        quoteData.items.push(item);
      });

      console.log(quoteData); // Debugging in console

      $.ajax({
        url: $("#base_url").val() + "quote_save",
        type: "POST",
        data: JSON.stringify(quoteData),
        contentType: "application/json",
        success: function (response) {
          console.log(response);
          if (response.success) {
            alert("Quote Saved Successfully!");
            window.location.href = $("#base_url").val() + "quote"; // Redirect to quote list
          } else {
            alert("Error saving quote: " + response.message);
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
      console.log("Add row clicked");

      const rowCount = $(".quote-body tr").length / 2 + 1; // Count only item rows
      const itemRow = `
            <tr class="quote_body_${rowCount}">
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
            <tr class="description-row quote_body_${rowCount}">
                <td colspan="7">
                    <textarea class="form-control" data-name="item_description" placeholder="Enter description..."></textarea>
                </td>
            </tr>
        `;
      $("#quote-body").append(itemRow);
    });

    $(document).on("click", ".remove-row", function () {
      const row = $(this).closest("tr");
      const rowClass = row.attr("class");
      row.next(`.description-row.${rowClass}`).remove();
      row.remove();
      updateRowNumbers();
    });

    function updateRowNumbers() {
      $(".quote-body tr:not(.description-row)").each(function (index) {
        $(this)
          .find("td:first")
          .text(String(index + 1).padStart(2, "0"));
        $(this).attr("class", `quote_body_${index + 1}`);
        $(this)
          .next(".description-row")
          .attr("class", `description-row quote_body_${index + 1}`);
      });
    }
  });

  $(document).ready(function () {
    $("#quote-form").submit(function (e) {
      e.preventDefault();

      let quoteID = $("#quote-form").attr("action").split("/").pop();
      let isUpdate = quoteID !== "add";

      let quoteData = {
        client_id: $("#client_id").val().trim(),
        quote_date: $("#quote_date").val().trim(),
        expiration_date: $("#expiration_date").val().trim(),
        sub_total:
          parseFloat($("#subtotal_amount").text().trim().replace("$", "")) || 0,
        discount: parseFloat($("#discount_input").val().trim()) || 0,
        tax: parseFloat($("td:contains('Tax:') + td span").text().trim()) || 0,
        total_amount:
          parseFloat($("#total_amount").text().trim().replace("$", "")) || 0,
        items: [],
      };

      // Collect quote items
      $("#quote-body tr:not(.description-row)").each(function () {
        let row = $(this);
        let nextRow = row.next(".description-row");

        let item = {
          item_name: row.find('[name*="[name]"]').val().trim(),
          item_qty:
            parseInt(row.find('[name*="[quantity]"]').val().trim()) || 0,
          item_units: row.find('[name*="[unit]"]').val().trim(),
          item_price:
            parseFloat(row.find('[name*="[unit_price]"]').val().trim()) || 0,
          item_total:
            parseFloat(row.find('[name*="[total_price]"]').val().trim()) || 0,
          item_description: nextRow.find("textarea").val().trim() || "",
        };

        quoteData.items.push(item);
      });

      console.log(quoteData);

      $.ajax({
        url: isUpdate
          ? $("#base_url").val() + "quote_update/" + quoteID
          : $("#base_url").val() + "quote_create",
        type: "POST",
        data: JSON.stringify(quoteData),
        contentType: "application/json",
        success: function (response) {
          console.log(response);
          if (response.success) {
            alert(
              isUpdate
                ? "Quote Updated Successfully!"
                : "Quote Saved Successfully!"
            );
            window.location.href = $("#base_url").val() + "quote";
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

  $(document).ready(function () {
    let today = new Date();
    let todayFormatted = today.toISOString().split("T")[0];

    $("#quote_date").val(todayFormatted);

    let expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 7);
    let expirationFormatted = expirationDate.toISOString().split("T")[0];

    $("#expiration_date").val(expirationFormatted);
  });

  function printQuote() {
    let printContents = document.getElementById("quote").innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
  }
})(jQuery);
