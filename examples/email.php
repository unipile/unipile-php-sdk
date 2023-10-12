<?php include('header.php');
 ?>
<div class="container mt-5">
    <h1>Email Demo</h1>
    <div class="row">
        <div class="col-md-4" style="max-height: 80vh; overflow-y: auto;">
            <ul class="list-group" id="folderList">
                <!-- Folder items will be added here dynamically -->
            </ul>
        </div>
        <div class="col-md-8">
            <div id="mailHeader">
                <!-- Mail header will be added here dynamically -->
            </div>
            <div class="mail-content border rounded p-3 mb-3" id="mailContent" style="max-height: 70vh; overflow-y: auto;">
                <!-- Mail content will be added here dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var folderList = document.getElementById('folderList');
        var mailContent = document.getElementById('mailContent');
        var mailHeader = document.getElementById('mailHeader');

        function callAPI(action, data = {}) {
            return fetch(`api-email.php?action=${action}`, {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .catch(error => {
                    console.error('API call error:', error);
                    throw error;
                });
        }

        function loadFolders() {
            callAPI('listFolders')
                .then(folders => {
                    folderList.innerHTML = '';
                    folders.items.forEach(folder => {
                        const folderItem = document.createElement('li');
                        folderItem.classList.add('list-group-item', 'folder-item', 'd-flex', 'align-items-center', 'justify-content-between', 'cursor-pointer');
                        folderItem.setAttribute('data-folder-id', folder.id);

                        folderItem.addEventListener('click', async () => {
                            const folderId = folderItem.getAttribute('data-folder-id');
                            const mails = await loadMails(folderId);
                        });

                        const folderName = document.createElement('span');
                        folderName.textContent = folder.name;

                        const mailCount = document.createElement('span');
                        mailCount.textContent = folder.mail_count;
                        mailCount.classList.add('badge', 'badge-primary', 'rounded-pill');

                        folderItem.appendChild(folderName);
                        folderItem.appendChild(mailCount);

                        folderItem.style.cursor = 'pointer';

                        folderList.appendChild(folderItem);
                    });
                })
                .catch(error => {
                    console.error('Error fetching folders:', error);
                });
        }

        function loadMails(folderId) {
            callAPI('listMails', {
                    folderId
                })
                .then(mails => {
                    mailContent.innerHTML = '';
                    mails.items.forEach(mail => {
                        const mailItem = document.createElement('div');
                        mailItem.classList.add('row', 'mb-3');

                        const mailInfo = document.createElement('div');
                        mailInfo.classList.add('col-8', 'offset', 'border', 'rounded', 'p-3', 'text-left');

                        const mailSubject = document.createElement('div');
                        mailSubject.textContent = mail.subject;
                        mailSubject.classList.add('font-weight-bold');

                        const mailFrom = document.createElement('div');
                        mailFrom.textContent = `From: ${mail.from}`;

                        const mailDate = document.createElement('div');
                        mailDate.textContent = new Date(mail.date).toLocaleString();

                        mailInfo.appendChild(mailSubject);
                        mailInfo.appendChild(mailFrom);
                        mailInfo.appendChild(mailDate);

                        mailItem.appendChild(mailInfo);

                        mailItem.style.cursor = 'pointer';

                        mailItem.addEventListener('click', async () => {
                            const mailContent = await loadMailContent(mail.id);
                        });

                        mailContent.appendChild(mailItem);
                    });
                })
                .catch(error => {
                    console.error('Error fetching mails:', error);
                });
        }

        function loadMailContent(mailId) {
            callAPI('getMail', {
                    mailId
                })
                .then(mail => {
                    mailHeader.innerHTML = '';
                    mailContent.innerHTML = '';

                    const mailSubject = document.createElement('h2');
                    mailSubject.textContent = mail.subject;

                    const mailSender = document.createElement('div');
                    mailSender.textContent = `From: ${mail.from}`;

                    const mailDate = document.createElement('div');
                    mailDate.textContent = new Date(mail.date).toLocaleString();

                    const mailBody = document.createElement('div');
                    mailBody.innerHTML = mail.body;

                    mailHeader.appendChild(mailSubject);
                    mailContent.appendChild(mailSender);
                    mailContent.appendChild(mailDate);
                    mailContent.appendChild(mailBody);
                })
                .catch(error => {
                    console.error('Error fetching mail content:', error);
                });
        }

        loadFolders();
    });
</script>
</body>

</html>