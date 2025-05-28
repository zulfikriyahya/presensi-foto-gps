@extends('layouts.dashboard')
@section('isi')
    <center>
        <div class="container-fluid">
            <div class="card col-lg-8">
                <div class="mt-4 p-3">
                    <div class="form-group">
                        <label for="name" class="float-left">Nama</label>
                        <input type="text" class="form-control" value="{{ $karyawan->name }}" disabled id="name">
                    </div>
                    <input type="hidden" name="username" id="username" value="{{ $karyawan->username }}">
                    <video id="video" autoplay></video>
                    <br>
                    <button id="capture" class="btn btn-primary mt-4">Capture Image</button>
                </div>
            </div>
        </div>
    </center>
    <br>
    @push('script')
        <script src="{{ url('/face/dist/face-api.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let video = document.getElementById("video");
            let canvas = document.body.appendChild(document.createElement("canvas"));
            let ctx = canvas.getContext("2d");
            let displaySize;

            let width = 800;
            let height = 600;

            const startSteam = () => {
                navigator.mediaDevices.getUserMedia({
                    video: {facingMode: "user", width, height},
                    audio : false
                }).then((steam) => {video.srcObject = steam});
            }

            console.log(faceapi.nets);
            Promise.all([
                faceapi.nets.ageGenderNet.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.ssdMobilenetv1.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.tinyFaceDetector.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceLandmark68Net.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceRecognitionNet.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceExpressionNet.loadFromUri("{{ url('/face/weights') }}")
            ]).then(startSteam);

            $(document).ready(async function(){
                const descriptions = [];
                $("#capture").click(async function(){
                    var username = $('#username').val();
                    const label = username;
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    var video = document.getElementById('video');
                    context.drawImage(video, 0, 0, 800, 600);
                    var capURL = canvas.toDataURL('image/png');
                    var canvas2 = document.createElement('canvas');
                    canvas2.width = 800;
                    canvas2.height = 600;
                    var ctx = canvas2.getContext('2d');
                    ctx.drawImage(video, 0, 0, 800, 600);
                    var new_image_url = canvas2.toDataURL();
                    var img = document.createElement('img');
                    img.src = new_image_url;

                    const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                    console.log(detections);
                    if( detections != null){
                        descriptions.push(detections.descriptor);
                        var descrip = descriptions;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type : 'POST',
                            url : "{{ url('/pegawai/face/ajaxPhoto') }}",
                            data :  {image: img.src ,path: username},
                            cache : false,
                            success: function(msg){
                                console.log(msg);
                            },
                            error: function(data){
                                console.log('error:' ,data);
                            }
                        })
                        var postData = new faceapi.LabeledFaceDescriptors(label, descrip);
                        $.ajax({
                            type : 'POST',
                            url : "{{ url('/pegawai/face/ajaxDescrip') }}",
                            data :  { myData: JSON.stringify(postData) },
                            datatype : 'json',
                            cache : false,
                            success: function(msg){
                                Swal.fire('Berhasil Daftar Wajah!', '', 'success');
                                setInterval(function() {
                                    window.location.href = "{{ url('/pegawai') }}";
                                }, 2000);
                            },
                            error: function(data){
                                console.log('error:' ,data);
                            }
                        })
                    }
                });
            });
        </script>
    @endpush
@endsection
