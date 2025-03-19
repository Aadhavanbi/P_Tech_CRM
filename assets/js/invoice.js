'use strict';

(function ($) {

  $("#saveInvoice").click(function() {
    console.log("yes come");
    
      let invoiceData = [];

      $("#invoice-body tr").each(function() {
          let row = {
              item_name: $(this).find(".item-name").val(),
              item_qty: $(this).find(".item-qty").val(),
              item_units: $(this).find(".item-units").val(),
              item_price: $(this).find(".item-price").val(),
              item_total: $(this).find(".item-total").val(),
          };
          invoiceData.push(row);
      });

      console.log(invoiceData); // Debug: Check the data in console

      $.ajax({
          url: "<?= base_url('invoice_save'); ?>",
          type: "POST",
          data: {
              invoice: invoiceData
          },
          dataType: "json",
          success: function(response) {
              if (response.success) {
                  alert("Invoice Saved Successfully!");
              } else {
                  alert("Error saving invoice!");
              }
          },
          error: function() {
              alert("AJAX request failed!");
          },
      });
  });
  $('#addRow').click(function() {
      const rowCount = $('#invoice-table tbody tr').length + 1;
      const newRow = `
          <tr>
              <td>${String(rowCount).padStart(2, '0')}</td>
              <td><input type="text" class="form-control" value="New Item"></td>
              <td><input type="number" class="form-control" value="1"></td>
              <td><input type="text" class="form-control" value="PC"></td>
              <td><input type="number" class="form-control" value="0.00" step="0.01"></td>
              <td><input type="number" class="form-control" value="0.00" step="0.01"></td>
              <td class="text-center">
                  <button type="button" class="remove-row"><iconify-icon icon="ic:twotone-close" class="text-danger-main text-xl"></iconify-icon></button>
              </td>
          </tr>
      `;
      $('#invoice-table tbody').append(newRow);
  });

  $(document).on('click', '.remove-row', function() {
      $(this).closest('tr').remove();
      updateRowNumbers();
  });

  function updateRowNumbers() {
    $('#invoice-table tbody tr').each(function(index) {
      $(this).find('td:first').text(String(index + 1).padStart(2, '0'));
    });
  }

  // Make table cells editable on click
  $('.editable').click(function() {
    const cell = $(this);
    const originalText = cell.text().substring(1); // Remove the leading ':'
    const input = $('<input type="text" class="form-control" />').val(originalText);

    cell.empty().append(input);

    input.focus().select();

    input.blur(function() {
        const newText = input.val();
        cell.text(' ' + newText);
    });

    input.keypress(function(e) {
        if (e.which == 13) { // Enter key
            const newText = input.val();
            cell.text(':' + newText);
        }
    });
  });
})(jQuery);



