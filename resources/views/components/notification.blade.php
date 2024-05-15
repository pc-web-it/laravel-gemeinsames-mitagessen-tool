<div id="notification-container" class="fixed bottom-5 right-5 z-50">
    @if ($errors->any())
        <div id="notification" class="bg-red-500 text-white py-2 px-4 rounded shadow-md flex items-center">
            <div>
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
            <button id="close-notification" class="ml-auto">
                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 11.414l3.536 3.536 1.414-1.414L11.414 10l3.536-3.536-1.414-1.414L10 8.586 6.464 5.05 5.05 6.464 8.586 10l-3.536 3.536 1.414 1.414L10 11.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    @endif
</div>
<script>
    // Cerrar la notificación automáticamente después de 5 segundos
    setTimeout(function(){
        var notification = document.getElementById('notification');
        if(notification) {
            notification.style.display = 'none';
        }
    }, 5000);

    // EventListener para cerrar la notificación manualmente
    var closeButton = document.getElementById('close-notification');
    if(closeButton) {
        closeButton.addEventListener('click', function() {
            var notification = document.getElementById('notification');
            if(notification) {
                notification.style.display = 'none';
            }
        });
    }
</script>
