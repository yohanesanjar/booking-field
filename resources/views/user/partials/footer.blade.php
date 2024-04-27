<!-- Contact -->
<div id="contact" class="form-1 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="h2-heading">Contact Us</h2>
                <ul class="list-unstyled li-space-lg">
                    <li><i class="fas fa-map-marker-alt"></i> &nbsp;{{ $data->address }}</li>
                    <li><i class="fas fa-phone"></i> &nbsp;<a href="tel:{{ $data->phone }}">{{ $data->phone }}</a></li>
                    <li><i class="fas fa-envelope"></i> &nbsp;<a
                            href="mailto:{{ $data->email }}">{{ $data->email }}</a>
                    </li>
                </ul>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of form-1 -->
<!-- end of contact -->


<!-- Copyright -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12 justify-content-center">
                <p class="p-small statement">Copyright © Jaya Abadi Sports</p>
            </div> <!-- end of col -->
        </div> <!-- enf of row -->
    </div> <!-- end of container -->
</div> <!-- end of copyright -->
<!-- end of copyright -->