<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="{{ URL::asset('mobile_assets/js/lib/jquery-3.4.1.min.js') }}"></script>
<!-- Bootstrap-->
<script src="{{ URL::asset('mobile_assets/js/lib/popper.min.js') }}"></script>
<script src="{{ URL::asset('mobile_assets/js/lib/bootstrap.min.js')}}"></script>
<!-- Ionicons -->

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!-- Owl Carousel -->
<script src="{{ URL::asset('mobile_assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<!-- jQuery Circle Progress -->
<script src="{{ URL::asset('mobile_assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
<!-- Base Js File -->
<script src="{{ URL::asset('mobile_assets/js/base.js') }}"></script>

@livewireScripts
<script>
  window.addEventListener('CloseModalAll', event => {
      console.log("CloseModalAll");
        $(".modal").modal('hide');             
    });

  window.addEventListener('CloseModal', event => {
      console.log("CloseModal "+event.detail.modal);
        $(event.detail.modal).modal('hide');             
    });
  
    window.addEventListener('ShowModal', event => { 
      console.log("ShowModal "+event.detail.modal);
        $(event.detail.modal).modal('show');      
    });

    
</script>