<footer class="main-footer" style="position: fixed; bottom: 0; right:0; left:0; z-index:999;">
    <div class="row align-items-center d-flex justify-content-between">
        <div class="col-auto">
            <a class="btn btn-block" href="{{ url('/dashboard') }}"><i class="fas fa-home" style="{{ Request::is('dashboard*') ? 'color: blue' : '' }}"></i><br><span style="font-size: 10px; {{ Request::is('dashboard*') ? 'color: blue' : '' }}">Home</span>
        </a>
        </div>

        <!--<div class="col-auto">-->
        <!--    <a class="btn btn-block" href="{{ url('/cuti') }}"><i class="fa fas fa-hourglass-half" style="{{ Request::is('cuti*') ? 'color: blue' : '' }}"></i><br><b style="font-size: 12px; {{ Request::is('cuti*') ? 'color: blue' : '' }}">Cuti</b></a>-->
        <!--</div>-->

        <div class="col-auto">
            <a class="btn btn-block" href="{{ url('/my-absen') }}"><i class="fas fa-history" style="{{ Request::is('my-absen*') ? 'color: blue' : '' }}"></i><br><span style="font-size: 9px; {{ Request::is('my-absen*') ? 'color: blue' : '' }}">Histori</span></a>
        </div>

        <div class="col-auto">
            <a class="btn btn-block bg-navy btn-lg my-1" style="background-color:navy; border: solid orange 2.5px; border-radius: 50px" href="{{ url('/absen') }}">
                <i class="fa fas fa-fingerprint" style="{{ Request::is('absen*') ? 'color: red' : '' }}"></i>
            </a>
        </div>

        <div class="col-auto">
            <a class="btn btn-block" href="{{ url('https://wa.me/6285218893358?text=Assalamualaikum, mohon bantuan saya terkendala presensi.') }}"><i class="fab fa-whatsapp"></i><br><span style="font-size: 10px">Chat</span></a>
        </div>

        <div class="col-auto">
            <a class="btn btn-block" href="{{ url('https://sekolahalampandeglang.id') }}"><i class="far fa-life-ring"></i><br><span style="font-size: 10px">Web</span></a>
        </div>

        <!--<div class="col-auto">-->
        <!--    <a class="btn btn-block" href="{{ url('/my-dokumen') }}"><i class="fa fas fa-folder" style="{{ Request::is('my-dokumen*') ? 'color: blue' : '' }}"></i><br><b style="font-size: 11px; {{ Request::is('my-dokumen*') ? 'color: blue' : '' }}">Dokumen</b></a>-->
        <!--</div>-->
    </div>
</footer>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin ingin Keluar?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ url('/logout') }}" method="post">
                    @csrf
                    <button class="btn btn-primary" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>
