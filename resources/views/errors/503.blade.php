<html>

<body>
    <h2></h2>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Erreurs 503
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 503</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! {{ $exception->getMessage() }}</h3>

                    <p>
                        Le site est en maitenance !! , Revenez plus tard !
                    </p>

                    {{-- <form class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i
                                        class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                    </form> --}}
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</body>

</html>