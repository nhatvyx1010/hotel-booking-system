<!doctype html>
<html lang="zxx">
    <head>
        <!-- Required Meta Tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS --> 
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
        <!-- Animate Min CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.min.css')}}">
        <!-- Flaticon CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/fonts/flaticon.css')}}">
        <!-- Boxicons CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/boxicons.min.css')}}">
        <!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/magnific-popup.css')}}">
        <!-- Owl Carousel Min CSS --> 
        <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.theme.default.min.css')}}">
        <!-- Nice Select Min CSS --> 
        <link rel="stylesheet" href="{{asset('frontend/assets/css/nice-select.min.css')}}">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/meanmenu.css')}}">
        <!-- Jquery Ui CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery-ui.css')}}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">
        <!-- Theme Dark CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/theme-dark.css')}}">

        <link rel="stylesheet" href="{{asset('frontend/assets/css/custom-chatbot.css')}}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{asset('frontend/assets/img/favicon.png')}}">
	    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

        <title>Hotel Booking</title>
    </head>
    <body>

        <!-- PreLoader Start -->
        <div class="preloader">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="sk-cube-area">
                        <div class="sk-cube1 sk-cube"></div>
                        <div class="sk-cube2 sk-cube"></div>
                        <div class="sk-cube4 sk-cube"></div>
                        <div class="sk-cube3 sk-cube"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PreLoader End -->

        <!-- Top Header Start -->
        @include('frontend.body.header')
        <!-- Top Header End -->

        <!-- Start Navbar Area -->
        @include('frontend.body.navbar')
        <!-- End Navbar Area -->

        @yield('main')

        <!-- Footer Area -->
        @include('frontend.body.footer')
        <!-- Footer Area End -->

        

        <div class="container">
	<div class="row">
	 <div id="Smallchat">
    <div class="Layout Layout-open Layout-expand Layout-right" style="background-color: #3F51B5;color: rgb(255, 255, 255);opacity: 5;border-radius: 10px;">
      <div class="Messenger_messenger">
        <div class="Messenger_header" style="background-color: rgb(22, 46, 98); color: rgb(255, 255, 255);">
          <h4 class="Messenger_prompt">Chúng tôi có thể giúp gì cho bạn?</h4> <span class="chat_close_icon"><i class="fa fa-window-close" aria-hidden="true"></i></span> </div>
        <div class="Messenger_content">
          <div class="Messages">
            <div class="Messages_list" id="chat-messages"></div>
          </div>
          <div class="Input Input-blank">
            <textarea class="Input_field" id="chat-input" placeholder="Send a message..." style="height: 20px;"></textarea>
            <button class="Input_button Input_button-send" id="chat-send">
              <div class="Icon" style="width: 18px; height: 18px;">
                <svg width="57px" height="54px" viewBox="1496 193 57 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 18px; height: 18px;">
                  <g id="Group-9-Copy-3" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(1523.000000, 220.000000) rotate(-270.000000) translate(-1523.000000, -220.000000) translate(1499.000000, 193.000000)">
                    <path d="M5.42994667,44.5306122 L16.5955554,44.5306122 L21.049938,20.423658 C21.6518463,17.1661523 26.3121212,17.1441362 26.9447801,20.3958097 L31.6405465,44.5306122 L42.5313185,44.5306122 L23.9806326,7.0871633 L5.42994667,44.5306122 Z M22.0420732,48.0757124 C21.779222,49.4982538 20.5386331,50.5306122 19.0920112,50.5306122 L1.59009899,50.5306122 C-1.20169244,50.5306122 -2.87079654,47.7697069 -1.64625638,45.2980459 L20.8461928,-0.101616237 C22.1967178,-2.8275701 25.7710778,-2.81438868 27.1150723,-0.101616237 L49.6075215,45.2980459 C50.8414042,47.7885641 49.1422456,50.5306122 46.3613062,50.5306122 L29.1679835,50.5306122 C27.7320366,50.5306122 26.4974445,49.5130766 26.2232033,48.1035608 L24.0760553,37.0678766 L22.0420732,48.0757124 Z" id="sendicon" fill="#96AAB4" fill-rule="nonzero"></path>
                  </g>
                </svg>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--===============CHAT ON BUTTON STRART===============-->
    <div class="chat_on"> <span class="chat_on_icon"><i class="fa fa-comments" aria-hidden="true"></i></span> </div>
    <!--===============CHAT ON BUTTON END===============-->
  </div>
	</div>
</div>

        <!-- Jquery Min JS -->
        <script src="{{asset('frontend/assets/js/jquery.min.js')}}"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Magnific Popup Min JS -->
        <script src="{{asset('frontend/assets/js/jquery.magnific-popup.min.js')}}"></script>
        <!-- Owl Carousel Min JS -->
        <script src="{{asset('frontend/assets/js/owl.carousel.min.js')}}"></script>
        <!-- Nice Select Min JS -->
        <script src="{{asset('frontend/assets/js/jquery.nice-select.min.js')}}"></script>
        <!-- Wow Min JS -->
        <script src="{{asset('frontend/assets/js/wow.min.js')}}"></script>
        <!-- Jquery Ui JS -->
        <script src="{{asset('frontend/assets/js/jquery-ui.js')}}"></script>
        <!-- Meanmenu JS -->
        <script src="{{asset('frontend/assets/js/meanmenu.js')}}"></script>
        <!-- Ajaxchimp Min JS -->
        <script src="{{asset('frontend/assets/js/jquery.ajaxchimp.min.js')}}"></script>
        <!-- Form Validator Min JS -->
        <script src="{{asset('frontend/assets/js/form-validator.min.js')}}"></script>
        <!-- Contact Form JS -->
        <script src="{{asset('frontend/assets/js/contact-form-script.js')}}"></script>
        <!-- Custom JS -->
        <script src="{{asset('frontend/assets/js/custom.js')}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>

<script>
// CHAT BOOT MESSENGER////////////////////////
$(document).ready(function(){
    $(".chat_on").click(function(){
        $(".Layout").toggle();
        $(".chat_on").hide(300);
    });
    
       $(".chat_close_icon").click(function(){
        $(".Layout").hide();
           $(".chat_on").show(300);
    });
    
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');
        const chatMessages = document.getElementById('chat-messages');

        // Hàm để hiển thị hiệu ứng loading
        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'loading-message';
            loadingDiv.className = 'message-bubble bot-message loading'; // Thêm class 'loading' để có thể стилизовать
            loadingDiv.textContent = 'Chờ một chút ...';
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Hàm để ẩn hiệu ứng loading
        function hideLoading() {
            const loadingDiv = document.getElementById('loading-message');
            if (loadingDiv) {
                loadingDiv.remove();
            }
        }

        chatSend.addEventListener('click', function () {
            const message = chatInput.value.trim();
            if (message !== '') {
                // Tạo thẻ div chứa tin nhắn
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message-bubble user-message';
                messageDiv.textContent = message;

                // Thêm vào danh sách tin nhắn
                chatMessages.appendChild(messageDiv);

                // Reset input
                chatInput.value = '';

                // Scroll xuống cuối
                chatMessages.scrollTop = chatMessages.scrollHeight;

                console.log(message);
                showLoading();

                // Ví dụ: gọi API Laravel ở đây nếu cần
                fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                })
                .then(res => res.json())
                .then(data => {
                    hideLoading();
                    console.log(data);  // Xem dữ liệu trả về từ server
                    if (data.error) {
                        alert('Có lỗi xảy ra: ' + data.error);
                    } else {
                        const botMessage = document.createElement('div');
                        botMessage.className = 'message-bubble bot-message';
                        botMessage.textContent = data.response;  // Sử dụng 'response' từ API
                        chatMessages.appendChild(botMessage);
                    }
                });
            }
        });
    });
</script>


    </body>
</html>
