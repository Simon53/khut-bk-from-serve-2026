      <footer class="footer topGap-1">
         <div class="ribon"></div>
         <div class="d-flex justify-content-center py-1 py-bottm">
            <img src="{{asset('/images/top-logo.png')}}" class="img-fluid mt-4 mt-4Moblile" alt="..." style="width:60px">  
         </div>
         <div class="d-flex justify-content-center py-1 mar-text-bottom">
            <img src="{{asset('/images/khut-text.png')}}" class="img-fluid" alt="..." style="width:110px">              
         </div>
         <div class="d-flex justify-content-center py-1 footer-title">
            <div class="p-2 text-center">An art shop of handmade products promoting the beauty of accepting imperfection </div>             
         </div>
         <div class="d-flex justify-content-center py-1 footer-title mt-4 mt-4Moblile">
            <a href="https://www.facebook.com/khut.art" target="_blank"><img src="{{asset('/images/facebook.png')}}" class="img-fluid p-1" alt="..."></a>
            <a href="https://www.instagram.com/khut.art?igsh=MXR1azV1d24zNnk2NQ%3D%3D" target="_blank"><img src="{{asset('/images/istagram.png')}}" class="img-fluid p-1" alt="..."></a>   
            <!--a href="https://www.youtube.com/@khutart" target="_blank"><img src="{{asset('/images/youtube.png')}}" class="img-fluid p-1" alt="..."></a-->       
         </div>
         <div class="py-1 text-center teadeClass">
             khut.art.bangladesh@gmail.com<br>
            <p>Trade Licence No.: TRAD/DNCC/072364/2022</p>      
         </div>
         <div class="ribon-bottom" style="margin-top:-10px"></div>
         <div class="bd-example">
            <div class="d-flex flex-wrap justify-content-center footer-genric">
               @foreach($footerMenus as $menu)
                  <div>
                        <a href="{{ url('menu/'.$menu->slug) }}">{{ $menu->name }}</a>
                  </div>
               @endforeach
            </div>
         </div>
         <div class="d-flex justify-content-center ribon-footer py-1">
            <p>© 2025 – All right reserved | Designed &amp; Developed by <a style="color: #e8ddd7;" href="#">Khut</a></p>
         </div>
      </footer>


      <script>
         // Global variable for Laravel route
         const chartUrl = "{{ route('chart.index') }}";
           window.BASE_URL = "{{ url('/') }}";
      </script>
    <script src="{{ asset('js/search.js') }}"></script>