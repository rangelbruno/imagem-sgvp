function updateBulkVoteButton() {
    const selectedItems = document.querySelectorAll('.todochkbox:checked');
    const bulkVoteBtn = document.getElementById('bulkVoteBtn');

    if (selectedItems.length > 1) {
        bulkVoteBtn.style.display = 'inline-block';
    } else {
        bulkVoteBtn.style.display = 'none';
    }
}

function checkall(masterCheckboxId, childCheckboxClass) {
    const masterCheckbox = document.getElementById(masterCheckboxId);
    const childCheckboxes = document.getElementsByClassName(childCheckboxClass);

    masterCheckbox.addEventListener('change', () => {
        for (let i = 0; i < childCheckboxes.length; i++) {
            childCheckboxes[i].checked = masterCheckbox.checked;
        }
        updateBulkVoteButton();
    });

    for (let i = 0; i < childCheckboxes.length; i++) {
        childCheckboxes[i].addEventListener('change', () => {
            masterCheckbox.checked = Array.from(childCheckboxes).every(checkbox => checkbox.checked);
            updateBulkVoteButton();
        });
    }
}

checkall('todoAll', 'todochkbox');
$('[data-toggle="tooltip"]').tooltip()