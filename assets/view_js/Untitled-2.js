/**
 * Product Attributes Management
 * 
 * This script handles dynamic attribute selection, ensuring proper
 * display of attribute value fields and preventing duplicate selections
 * across multiple attribute dropdowns.
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize chosen plugin for existing selects
    $(".chosen-select").chosen({ width: "100%" });
    
    let attributeIndex = 2; // Track new attribute indexes
    let selectedAttributes = new Set(); // Track selected attribute IDs

    /**
     * Add new attribute field
     */
    document.getElementById('add_more_attributes').addEventListener('click', function () {
        // Get the attributes container
        let attributesContainer = document.getElementById('attributes_container');

        // Create a new div for the attribute
        let newAttributeDiv = document.createElement('div');
        newAttributeDiv.classList.add('col-lg-6', 'mb-3');
        newAttributeDiv.setAttribute('data-index', attributeIndex); // Add a data-index for tracking

        // Create a form group for the attribute
        let formGroupDiv = document.createElement('div');
        formGroupDiv.classList.add('form-group');

        // Create label for the select dropdown
        let label = document.createElement('label');
        label.classList.add('col-form-label');
        label.setAttribute('for', 'fk_product_attribute_id_' + attributeIndex);
        label.innerHTML = 'Attribute <span class="text-danger">*</span>';

        // Create new attribute select dropdown
        let select = document.createElement('select');
        select.classList.add('chosen-select', 'form-control', 'fk_product_attribute_id');
        select.setAttribute('id', 'fk_product_attribute_id_' + attributeIndex);
        select.setAttribute('name', 'fk_product_attribute_id[]');
        select.setAttribute('style', 'width: 100%;'); // Set width to 100% for Chosen select

        // Copy existing options from the first dropdown but disable already selected options
        let firstDropdown = document.querySelector('.fk_product_attribute_id');
        if (firstDropdown) {
            // Clone options but handle disabled state
            Array.from(firstDropdown.options).forEach(option => {
                let newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.text = option.text;
                
                // Copy data attributes
                if (option.dataset.type) {
                    newOption.dataset.type = option.dataset.type;
                }
                
                // Disable empty option and already selected attributes
                if (option.value === "") {
                    newOption.disabled = true;
                } else if (selectedAttributes.has(option.value)) {
                    newOption.disabled = true;
                }
                
                select.appendChild(newOption);
            });
        }

        // Create remove button
        let removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-danger', 'mt-2', 'remove-attribute');
        removeButton.textContent = 'Remove';

        // Append elements
        formGroupDiv.appendChild(label);
        formGroupDiv.appendChild(select);
        formGroupDiv.appendChild(removeButton);
        newAttributeDiv.appendChild(formGroupDiv);
        attributesContainer.appendChild(newAttributeDiv);

        // Initialize Chosen plugin for the new select
        $("#" + select.id).chosen({ width: "100%" });

        // Increment index for the next attribute
        attributeIndex++;
    });

    /**
     * Remove attribute field when "Remove" button is clicked
     */
    document.getElementById('attributes_container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-attribute')) {
            // Get the parent div (the attribute div)
            let attributeDiv = e.target.closest('.col-lg-6');
            let attributeIndex = attributeDiv.getAttribute('data-index'); // Get the index of the attribute
            
            // Get the attribute ID that was selected in this row
            let selectedElement = attributeDiv.querySelector('.fk_product_attribute_id');
            let selectedValue = selectedElement ? selectedElement.value : null;
            
            // Remove the corresponding attribute value row
            document.querySelectorAll(`#attribute_fields_container [data-index="${attributeIndex}"]`).forEach(el => el.remove());
            
            // If a value was selected, remove it from our tracking Set and update other dropdowns
            if (selectedValue && selectedValue !== "") {
                selectedAttributes.delete(selectedValue);
                updateAllDropdowns();
            }
            
            // Remove the attribute div itself
            attributeDiv.remove();
        }
    });

    /**
     * Update all dropdowns to reflect current selections
     */
    function updateAllDropdowns() {
        // Get all attribute dropdowns
        let allDropdowns = document.querySelectorAll('.fk_product_attribute_id');
        
        allDropdowns.forEach(dropdown => {
            let selected = dropdown.value;
            
            // Update each option's disabled state
            Array.from(dropdown.options).forEach(option => {
                if (option.value === selected) {
                    option.disabled = false; // Keep the currently selected option enabled
                } else if (option.value === "") {
                    // Disable the "Select Attribute" option if any attribute is already selected
                    option.disabled = selected !== ""; 
                } else {
                    option.disabled = selectedAttributes.has(option.value);
                }
            });
            
            // Update chosen
            $(dropdown).trigger("chosen:updated");
        });
    }

    /**
     * Handle attribute selection change
     */
    $(document).on("change", ".fk_product_attribute_id", function () {
        var $this = $(this);
        var selectedType = $this.find("option:selected").data("type");
        var attributeName = $this.find("option:selected").text();
        var attributeId = $this.val();
        var attributeDiv = $this.closest('.col-lg-6');
        var attributeIndex = attributeDiv.attr('data-index') || '1'; // Default to 1 for first dropdown
        var previousValue = $this.data('previous-value');
        
        // Remove previous selection from tracking
        if (previousValue && previousValue !== "") {
            selectedAttributes.delete(previousValue);
        }
        
        // Store current selection for future reference
        $this.data('previous-value', attributeId);
        
        // Add new selection to tracking if not empty
        if (attributeId && attributeId !== "") {
            selectedAttributes.add(attributeId);
        }
        
        // Update all dropdowns with new disabled states
        updateAllDropdowns();
        
        if (!attributeId) {
            // If no attribute is selected, remove the corresponding value field
            $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`).remove();
            return;
        }

        // Fetch additional data related to selected attribute type dynamically
        $.ajax({
            url: frontend + controllerName + "/get_attribute_values_on_product_attributes_id",
            type: "POST",
            data: { attribute_id: attributeId },
            dataType: "json",
            success: function (response) {
                // Create a div to contain this attribute value, using column approach to avoid overlapping
                var fieldHtml = `<div class="col-lg-6 mb-3" data-index="${attributeIndex}">`;
                fieldHtml += `<div class="form-group"><label class="col-form-label">${attributeName}</label>`;
                
                if (selectedType === "text") {
                    fieldHtml += `<input type="text" name="attributes_value[]" id="attributes_value_${attributeIndex}" class="form-control" placeholder="Enter ${attributeName}">`;
                } else if (selectedType === "dropdown") {
                    fieldHtml += `<select class="chosen-select form-control" name="attributes_value[]" id="attributes_value_${attributeIndex}" style="width:100%;">                                    
                    <option value="" disabled selected>Select ${attributeName}</option>`;
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<option value="${item.id}">${item.attribute_value}</option>`;
                    });
                    fieldHtml += `</select>`;
                } else if (selectedType === "checkbox") {
                    $.each(response.data, function (index, item) {
                        fieldHtml += `<div>
                                         <input type="checkbox" name="attributes_value[]" id="attributes_value_${attributeIndex}_${index}" value="${item.attribute_value}"> ${item.label}
                                       </div>`;
                    });
                }
                fieldHtml += `</div></div>`;

                // Check if there's already a field for this index
                var existingField = $("#attribute_fields_container").find(`[data-index="${attributeIndex}"]`);
                if (existingField.length > 0) {
                    existingField.replaceWith(fieldHtml);
                } else {
                    $("#attribute_fields_container").append(fieldHtml);
                }

                // Initialize Chosen plugin for new dropdowns with a slight delay to ensure DOM is ready
                setTimeout(function () {
                    $(".chosen-select").chosen("destroy"); // Just in case
                    $(".chosen-select").chosen({ width: "100%" }).trigger("chosen:updated");
                }, 50);
            },
            error: function () {
                alert("Failed to fetch attribute type values.");
            }
        });
    });

    // Initialize tracking of already selected attributes on page load
    function initializeSelectedAttributes() {
        const existingDropdowns = document.querySelectorAll('.fk_product_attribute_id');
        existingDropdowns.forEach(dropdown => {
            const value = dropdown.value;
            if (value && value !== "") {
                selectedAttributes.add(value);
                $(dropdown).data('previous-value', value);
            }
        });
        
        // Initial update of all dropdowns
        updateAllDropdowns();
    }

    // Run initialization
    initializeSelectedAttributes();
});