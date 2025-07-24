<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .chatbox {
            position: fixed;
            /* bottom: 20px;
            left: 70px; */
            width: 450px;
            height: 550px;
            border: 2px solid green;
            border-radius: 20px;
            background-color: rgb(209, 208, 208);
            display: flex;
            flex-direction: column;
        }

        #chatMessages {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
            padding: 10px;
        }

        #chatInput {
            display: flex;
            gap: 10px;
            padding: 10px;
            /* background: #fff; */
            border-top: 1px solid #ccc;
            background-color: rgb(80, 80, 80);
            border-radius: 0 0 20px 20px;
        }

        #messagebox {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #sendBtn {
            padding: 8px 15px;
            background: #25D366;
            /* WhatsApp green */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }



        .receivedMessage {
            background-color: #ffffff;
            border-radius: 8px 8px 8px 0px;
            max-width: 60%;
            padding: 8px 12px;
            margin: 8px 0;
            float: left;
            clear: both;
            color: #000;
            font-family: Arial, sans-serif;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .sentMessages {
            background-color: #dcf8c6;
            border-radius: 8px 8px 0px 8px;
            max-width: 60%;
            padding: 8px 12px;
            margin: 8px 0;
            float: right;
            clear: both;
            color: #000;
            font-family: Arial, sans-serif;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
@php
    // dd($id);
@endphp

<body class="bg-dark">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 d-flex justify-content-center">
            <div class="container chatbox" id="chatbox">
                <h4 class="text-center border rounded bg-dark text-white">{{ $userName->name }}</h4>
                <div id="chatMessages">
                    @php
                        // dd((int)session('haulerId'));
                    @endphp
                    @if ($messages)
                    @php
                        // dd($messages);
                    @endphp
                        @foreach ($messages as $m)
                            @if ($m->sender_id == session('haulerId'))
                                <div class="sentMessages">{{ $m->message }}</div>
                            @elseif ($m->sender_id == $id)
                                <div class="receivedMessage">{{ $m->message }}</div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div id="chatInput">
                    <input type="text" class="form-control" style="width:270px;" id="messagebox">
                    <button class="btn btn-success" id="sendBtn" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function scrollToBottom() {
            let chatMessages = document.getElementById("chatMessages");
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        window.onload = scrollToBottom;
        let messages;
        let userId = {{ $id }};
        let haulerId = {{ session('haulerId') }};
        // console.log(userId);
        // console.log(haulerId);
        function sendMessage() {
            messages = document.getElementById('messagebox').value;
            $.ajax({
                url: '/sendHaulerMessage',
                type: 'POST',
                data: {
                    message: messages,
                    senderId: haulerId,
                    receiverId: userId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#messagebox').val('');
                },
                error: function(xhr, status, error) {
                    console.log('Error Status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                }
            });

        }
        // console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));

        function viewMessage() {
            $.ajax({
                url: '/getHaulerMessages',
                type: 'GET',
                data: {
                    userid: userId
                },
                success: function(response) {
                    let chatBox = $('#chatMessages');
                    response.forEach(function(msg) {
                        if (msg.sender_id == haulerId) {
                            chatBox.append(`<div class="sentMessages">${msg.message}</div>`);
                        } else if (msg.sender_id == userId) {
                            chatBox.append(`<div class="receivedMessage">${msg.message}</div>`);
                        }

                        scrollToBottom();
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error Status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                }
            });
        }

        setInterval(viewMessage, 500);
    </script>
</body>

</html>
