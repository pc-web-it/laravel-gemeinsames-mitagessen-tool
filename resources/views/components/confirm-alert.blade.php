<div id="confirm-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Löschen bestätigen
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Möchten Sie "<span id="itemName"></span>" aus der Liste "<span id="listName"></span>" löschen?
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button id="confirm-delete" type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                Löschen
            </button>
            <button id="cancel-delete" type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                Zurück
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('confirm-modal');
        var itemNameElement = document.getElementById('itemName');
        var listNameElement = document.getElementById('listName');
        var confirmButton = document.getElementById('confirm-delete');
        var cancelButton = document.getElementById('cancel-delete');
        var formToSubmit = null;

        window.showConfirmModal = function(itemName, listName, formId) {
            itemNameElement.textContent = itemName;
            listNameElement.textContent = listName;
            formToSubmit = document.getElementById(formId);
            modal.classList.remove('hidden');
        };

        confirmButton.addEventListener('click', function() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });

        cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    });
</script>
