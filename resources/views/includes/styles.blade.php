 <!--     Fonts and icons     -->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
 <!-- Nucleo Icons -->
 <link href="{{ $web_source }}/assets/css/nucleo-icons.css" rel="stylesheet" />
 <link href="{{ $web_source }}/assets/css/nucleo-svg.css" rel="stylesheet" />
 <!-- Font Awesome Icons -->
 <link href="{{ $web_source }}/assets/css/nucleo-svg.css" rel="stylesheet" />
 <!-- CSS Files -->
 <link id="pagestyle" href="{{ $web_source }}/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

 <style>
     .error {
         color: crimson;
         margin: 2px;
         font-size: 14px;
     }

     .mb-large {
         margin-bottom: 5em;
     }


     /* Style the loader */
     #loader {
         display: none;
         position: fixed;
         z-index: 9999;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         width: 150px;
         height: 150px;
         border-radius: 50%;
         /* background-color: rgba(255, 255, 255, 0.8); */
         /* Add transparency to the background */
         /* box-shadow: 0px 0px 50px 10px rgba(0, 0, 0, 0.5); */
         text-align: center;
     }

     /* Style the spinner */
     .spinner {
         margin: 40px auto;
         width: 70px;
         height: 70px;
         border-radius: 50%;
         border: 8px solid #5E72E4;
         border-top-color: #000;
         animation: spin 1s infinite linear;
     }

     @keyframes spin {
         from {
             transform: rotate(0deg);
         }

         to {
             transform: rotate(360deg);
         }
     }
 </style>
