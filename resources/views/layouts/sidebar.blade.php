<div class="left-sidebar">
    <ul class="left-nav">
        <li class="active"><a href="#"><img src="assets/img/new/module.png" alt="" >  <br />	Modules	</a></li>
        <li ><a href="#"><img src="assets/img/new/icon6.png" alt="" >  <br />	Premade	</a></li>
        <li><a href="#"><img src="assets/img/new/mobile.png" alt="" ><br />	Preview 	</a></li>
        <li><a href="#"><img src="assets/img/new/save.png" alt="" ><br />	Save 	</a></li>
        <li><a href="#"><img src="assets/img/new/icon3.png" alt="" >	<br />	Export</a></li>
        <li><a href="#"><img src="assets/img/new/icon4.png" alt="" ><br />	send	</a></li>
    </ul>
</div>
<div class="sidebar">
    @if(isset(Auth::user()->email))
    <h3> Welcome,{{Auth::user()->email}}</h3>
    @endif
    <!--<div class="tab-one tab">
      <ul class="nav-sidebar">
        <li class="active"><a href="#"><img src="assets/img/new/img1.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img2.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img3.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img4.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img5.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img6.jpg" alt="" width="100%"></a></li>
        <li><a href="#"><img src="assets/img/new/img7.jpg" alt="" width="100%"></a></li>
      </ul>
     </div>-->
    <div class="tab-two tab">
        <ul class="premade">
            <li class="active"><a href="#"><img src="assets/img/new/heading.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/image.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/paragraph.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/button.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/gallery.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/heading.png" alt="" ></a></li>
            <li ><a href="#"><img src="assets/img/new/heading.png" alt="" ></a></li>

        </ul>
    </div>


</div>


