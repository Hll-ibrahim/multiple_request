<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--JQuery-->
    <script src="{{asset('jquery/jquery-3.6.0.js')}}"></script>

    <!--bootstrap 5.2.3-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Jquery 3.7-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Randevu</title>
</head>
<body>
<div class="container">

    <div class="row pt-4 pb-4" id="sessions">
        <h4>Randevu Durumu</h4>
        <div id="sessionContainer">
            <!-- Sessions will be dynamically added here -->
        </div>
        <div class="mb-4 col-12 d-flex gap-4">
            <div class="btn-group">
                <button id="addSessionBtn" class="btn w-auto"
                        style="padding: 8px 15px !important; font-size: 16px; background: linear-gradient(to right,#1e7a23,rgba(73,180,79,0.98)); color: #FFFFFF;">Randevu Ekle
                </button>
            </div>

            <div class="btn-group">
                <button id="removeSessionBtn" onclick="removeLastSession();" class="btn w-auto"
                        style="padding: 8px 15px !important; font-size: 16px;background:linear-gradient(to right, #B71C1C,#f55555); color: #FFFFFF;">Randevu Kaldır
                </button>
            </div>
            <div class="btn-group">
                <button id="saveSessionBtn" onclick="postAppointment(sessionIndex);" class="btn w-auto"
                        style="padding: 8px 15px !important; font-size: 16px;background:linear-gradient(to right, #01579B,#1986dc); color: #FFFFFF;">Kaydet
                </button>
            </div>

        </div>










        <script>

            var sessions = [];
            var sessionIndex = 0;
            var saveSessionBtn = document.getElementById("saveSessionBtn");
            var removeSessionBtn = document.getElementById("removeSessionBtn");

            document.getElementById("addSessionBtn").addEventListener("click", function () {
                var sessionContainer = document.getElementById("sessionContainer");
                var newSession = createSession(sessionIndex);
                sessionContainer.appendChild(newSession);
                sessions.push({
                    title: "",
                    content: "",
                });

                sessionIndex++;

                if (sessionIndex > 0) {
                    saveSessionBtn.style.display = "inline-block";
                    removeSessionBtn.style.display = "inline-block";
                }
            });

            if (sessionIndex === 0) {
                saveSessionBtn.style.display = "none";
                removeSessionBtn.style.display = "none";
            }


            function createSession(index) {
                var session = document.createElement("div");
                session.id = "session" + index;
                var sessionForm = document.createElement("form");
                sessionForm.id = "details_academician_modal" + index;
                sessionForm.innerHTML = `
    <div class="row mt-3 mb-4">
        <div id="namestage" class="form-group mb-4 col-12 d-flex" style="gap:3rem;">
            <div class="inp-group">
                <label>Title</label>
                <input class="form-control" type="text" name="title" id="title${index}">
            </div>
                <div class="inp-group">
                    <label>Content</label>
                    <input class="form-control" type="text" name="content" id="content${index}">
                </div>

                <input type="hidden" id="idHidden${index}">
            </div>
        </div>`;

                session.appendChild(sessionForm);

                return session;
            }

            function removeLastSession() {
                if (sessions.length > 0) {
                    var lastIndex = sessions.length - 1; // Son eklenen kontenjanın index değeri
                    var sessionContainer = document.getElementById("sessionContainer");
                    var sessionToRemove = document.getElementById("session" + lastIndex);
                    sessionContainer.removeChild(sessionToRemove);
                    sessions.splice(lastIndex, 1);
                    sessionIndex--; // sessionIndex'i azaltarak index değerini düzeltiyoruz.
                }

                if (sessionIndex === 0) {
                    saveSessionBtn.style.display = "none";
                    removeSessionBtn.style.display = "none";
                }
            }


            function postAppointment(count) {
                alert(count);

                var sessionCount = count - 1;
                var sessionData = [];

                for (var sessionIndex = 0; sessionIndex <= sessionCount; sessionIndex++) {
                    console.log("index=" + sessionIndex)
                    //var danismanId = ;
                    var title = document.getElementById('title' + sessionIndex).value;
                    var content = document.getElementById('content' + sessionIndex).value;

                    sessionData.push({
                        title: title,
                        content: content,
                    });
                }
                console.log(sessionData);

                $.ajax({
                    type: 'GET',
                    url: `{{route('create-appointment')}}`,
                    data: {
                        sessions: sessionData,
                    },
                    headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: 'Akademisyen Başarı ile Güncellendi',
                            confirmButtonText: 'Tamam'
                        })
                        window.location.href = ''
                    },
                    error: function (data) {
                        var errors = '';
                        for (datas in data.responseJSON.errors) {
                            errors += data.responseJSON.errors[datas] + '\n';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Başarısız',

                            html: errors,
                        });
                    }

                });
            }
        </script>






        <script>

        </script>

    </div>

</body>
</html>
