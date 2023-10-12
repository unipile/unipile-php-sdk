<?php include('header.php'); ?>
<div class="container mt-5">
    <h1>Chat Demo</h1>
    <div class="row">
        <div class="col-md-4" style="max-height: 80vh; overflow-y: auto;">
            <ul class="list-group" id="chatList">
                <!-- Chat items will be added here dynamically -->
            </ul>
        </div>
        <div class="col-md-8">
            <div id="chatInfo">
                <!-- Chat info will be added here dynamically -->
            </div>
            <div class="chat-box border rounded p-3 mb-3" id="chatMessages" style="max-height: 70vh; overflow-y: auto;">
                <!-- Chat messages will be added here dynamically -->
            </div>
            <form id="messageForm">
                <div class="form-group">
                    <textarea class="form-control" id="messageText" rows="3" placeholder="Type your message"></textarea>
                </div>
                <div class="form-group">
                    <label for="attachments">Select Attachments:</label>
                    <input type="file" id="attachments" name="attachments[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="message.js"></script>
</body>

</html>