document.addEventListener("DOMContentLoaded", function () {
  var chatList = document.getElementById("chatList");
  var chatMessages = document.getElementById("chatMessages");
  var chatInfo = document.getElementById("chatInfo");

  var messageForm = document.getElementById("messageForm");

  function callAPI(action, data = {}) {
    return fetch(`api-message.php?action=${action}`, {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .catch((error) => {
        console.error("API call error:", error);
        throw error;
      });
  }
  callAPI("listChats")
    .then((chats) => {
      chatList.innerHTML = "";
      chats.items.forEach((chat) => {
        const chatItem = document.createElement("li");
        chatItem.classList.add(
          "list-group-item",
          "chat-item",
          "d-flex",
          "align-items-center",
          "justify-content-between",
          "cursor-pointer"
        );
        chatItem.setAttribute("data-chat-id", chat.id);

        chatItem.addEventListener("click", async () => {
          const chatId = chatItem.getAttribute("data-chat-id");
          const chat = await getChat(chatId);
          const messages = await loadChatMessages(chatId);
        });

        const chatImage = document.createElement("div");
        chatImage.classList.add("chat-image", "rounded-circle");

        if (chat.image) {
          chatImage.style.backgroundImage = `url(${chat.image})`;
          chatImage.style.backgroundSize = "cover"; 
        } else {
          chatImage.classList.add("placeholder"); 

          chatImage.style.backgroundColor = "#ccc"; 
          chatImage.style.width = "50px"; 
          chatImage.style.height = "50px";
          chatImage.style.borderRadius = "50%"; 
          chatImage.style.display = "flex";
          chatImage.style.justifyContent = "center";
          chatImage.style.alignItems = "center";
          chatImage.style.fontWeight = "bold"; 
          chatImage.style.color = "#fff"; 
          chatImage.style.fontSize = "24px";
          chatImage.textContent = ""; 
        }

        const providerLogo = document.createElement("img");
        providerLogo.src = "icons/" + chat.account_type + ".png";
        providerLogo.alt = chat.account_type;
        providerLogo.classList.add("provider-logo", "mr-2");
        providerLogo.style.width = "24px";
        providerLogo.style.height = "24px";

        const chatName = document.createElement("span");
        const chatNameContainer = document.createElement("div");

        if (!chat.name) {
          callAPI("getChatAttendees", { chatId: chat.id })
            .then((attendees) => {
              var chatItem = document.querySelector(
                'li[data-chat-id="' + chat.id + '"]'
              );

              if (chatItem) {
                var nameElement = chatItem.querySelector(".name");
                if (nameElement) {
                  nameElement.textContent = attendees.items[0].name;
                }
              }
            })
            .catch((error) => {
              console.error("Error fetching attendees:", error);
            });
        }

        chatName.textContent = chat.name || "Chat with no name";

        if (chat.unread_count > 0) {
          chatName.classList.add("font-weight-bold");
        }
        chatName.style.whiteSpace = "nowrap";
        chatName.style.overflow = "hidden"; 
        chatName.style.textOverflow = "ellipsis"; 
        chatName.classList.add("name");

        chatNameContainer.appendChild(chatName);

        const unreadCount = document.createElement("span");
        if (chat.unread_count > 0) {
          unreadCount.textContent = chat.unread_count;
          unreadCount.classList.add("badge", "badge-danger", "ml-2");
        }

        const timestamp = document.createElement("small");
        timestamp.textContent = new Date(chat.timestamp).toLocaleTimeString();

        chatItem.appendChild(chatImage);
        chatItem.appendChild(providerLogo);
        chatItem.appendChild(chatNameContainer);
        chatItem.appendChild(unreadCount);
        chatItem.appendChild(timestamp);

        chatItem.style.cursor = "pointer";

        chatItem.addEventListener("mouseenter", () => {
          chatItem.classList.add("bg-light");
        });

        chatItem.addEventListener("mouseleave", () => {
          chatItem.classList.remove("bg-light");
        });

        chatList.appendChild(chatItem);
      });
    })
    .catch((error) => {
      console.error("Error fetching chats:", error);
    });

  function loadChatMessages(chatId) {
    callAPI("listChatMessages", {
      chatId,
    })
      .then((messages) => {
        chatMessages.innerHTML = "";
        messages.items.forEach((message) => {
          const messageContainer = document.createElement("div");
          messageContainer.classList.add("row", "mb-3");

          const messageContent = document.createElement("div");
          messageContent.classList.add(
            "col-8",
            "offset",
            "border",
            "rounded",
            "p-3",
            "text-left"
          );
          messageContent.textContent = message.text;

          if (message.is_event) {
            messageContent.classList.add(
              "bg-light",
              "text-muted",
              "small",
              "text-center"
            );
          } else if (message.is_sender) {
            messageContent.classList.add("bg-primary", "text-white", "ml-auto");
          } else {
            messageContent.classList.add("bg-light", "mr-auto");
          }

          if (message.attachments && message.attachments.length > 0) {
            const attachmentContainer = document.createElement("div");

            message.attachments.forEach((attachment) => {
              const attachmentElement = document.createElement("div");
              attachmentElement.classList.add("attachment");

              if (attachment.type === "img") {
                const imgElement = document.createElement("img");

                imgElement.style.width = "100%";
                imgElement.style.height = "auto";
                imgElement.style.cursor = "pointer";
                imgElement.style.transition = "opacity 0.3s";
                imgElement.style.opacity = "0"; 

                const placeholder = document.createElement("div");

                placeholder.style.width = "100%";
                placeholder.style.height = "auto";
                placeholder.style.backgroundColor = "transparent";
                placeholder.style.display = "flex";
                placeholder.style.alignItems = "center";
                placeholder.style.justifyContent = "center";
                placeholder.style.cursor = "pointer";

                placeholder.textContent = "Click to load & view image";

                placeholder.addEventListener("click", function () {
                  const attachmentUrl = `api-message.php?action=getAttachments&messageId=${message.id}&attachmentId=${attachment.id}`;

                  imgElement.src = attachmentUrl;
                  imgElement.style.opacity = "1"; 
                  imgElement.style.background = "none";
                });

                attachmentElement.appendChild(placeholder);
                attachmentElement.appendChild(imgElement);
              } else if (attachment.type === "video") {
                const videoElement = document.createElement("video");

                videoElement.style.width = "100%";
                videoElement.style.height = "auto";
                videoElement.style.cursor = "pointer";
                videoElement.style.transition = "opacity 0.3s";
                videoElement.style.opacity = "0"; 
                const placeholder = document.createElement("div");

                placeholder.style.width = "100%";
                placeholder.style.height = "auto";
                placeholder.style.backgroundColor = "transparent";
                placeholder.style.display = "flex";
                placeholder.style.alignItems = "center";
                placeholder.style.justifyContent = "center";
                placeholder.style.cursor = "pointer";

                placeholder.textContent = "Click to load & view video";

                placeholder.addEventListener("click", function () {
                  const attachmentUrl = `api-message.php?action=getAttachments&messageId=${message.id}&attachmentId=${attachment.id}`;

                  videoElement.src = attachmentUrl;
                  videoElement.style.opacity = "1"; 
                  videoElement.style.background = "none"; 
                  videoElement.setAttribute("controls", "");
                });

                attachmentElement.appendChild(placeholder);
                attachmentElement.appendChild(videoElement);
              } else {
                const downloadButton = document.createElement("a");
                downloadButton.href = `api-message.php?action=getAttachments&messageId=${message.id}&attachmentId=${attachment.id}`;
                downloadButton.target = "_blank";
                downloadButton.download = attachment.file_name;
                downloadButton.textContent = `Download ${attachment.file_name}`;
                downloadButton.classList.add(
                  "btn",
                  "btn-primary",
                  "attachment-download"
                );

                attachmentElement.appendChild(downloadButton);
              }

              attachmentContainer.appendChild(attachmentElement);
            });

            messageContainer.appendChild(attachmentContainer);
          }

          messageContainer.appendChild(messageContent);
          chatMessages.insertBefore(messageContainer,chatMessages.firstChild);
        });
        chatMessages.setAttribute("data-chat-id", chatId);
        chatMessages.scrollTop = chatMessages.scrollHeight;
      })
      .catch((error) => {
        console.error("Error fetching chat messages:", error);
      });
  }

  function getChat(chatId) {
    chatInfo.innerHTML = "";
    callAPI("getChat", {
      chatId,
    })
      .then((messages) => {
        const chatName = document.createElement("h2");

        if (messages.name) {
          chatName.textContent = messages.name;
        } else {
          callAPI("getChatAttendees", { chatId })
            .then((attendees) => {
              chatName.textContent = attendees.items[0].name;
            })
            .catch((error) => {
              console.error("Error fetching attendees:", error);
            });
        }

        chatName.textContent = chatName.textContent || "Chat with no name";

        chatInfo.appendChild(chatName);
        chatInfo.setAttribute("data-chat-id", chatId);
      })
      .catch((error) => {
        console.error("Error fetching chat messages:", error);
      });
  }

  messageForm.addEventListener("submit", function (event) {
    event.preventDefault();
    var messageText = document.getElementById("messageText").value;
    var chatId = chatMessages.getAttribute("data-chat-id");

    var attachments = document.getElementById("attachments").files;
    var formData = new FormData();

    formData.append("message", messageText);

    for (var i = 0; i < attachments.length; i++) {
      formData.append("attachments[]", attachments[i]);
    }

    fetch(`api-message.php?action=sendMessage&chatId=${chatId}`, {
      method: "POST",
      body: formData, 
    })
      .then((response) => response.json())
      .then((response) => {
        document.getElementById("messageText").value = "";
        document.getElementById("attachments").value = ""; 

        setTimeout(function () {
          loadChatMessages(chatId);
        }, 1000);
      })
      .catch((error) => {
        console.error("Error sending message:", error);
      });
  });
});
