console.log('main.js');


$(document).ready(function() {
    checkNotificationsCount();
    setInterval(function() {
        checkNotificationsCount()
    }, 15000);
})

function checkNotificationsCount() {
    $.ajax({
       'url': '/notification/count',
        'success': function (params) {
            console.log(params.count);
            let count = params.count;
            if (params.count >= 1000) {
                count  = Math.floor(params.count/100);
                count = count.toString() + "...";
            }

            $('#notifications-count').text(count);
        },
        'error': function (params) {
           console.log(params)
           alert('При проверки счетчика уведомлений произошла ошибка.')
        }
    });

    console.log('Проверяем кол-во непрочитанных уведомлений')
}

/**
 * Обновление csrf токнеа после того, как ajax был завершен
 * @param newToken
 */
function updateCsrf(newToken)
{
    console.log('Дописать функцию обновления токена');
}

/**
 * Показ уведомлений.
 * @param text
 * @param type
 */
function showAlert(text, type = 'success')
{
    alert(text);
}

