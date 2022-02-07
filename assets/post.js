import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/list";
import ImageTool from "@editorjs/image";
import LinkTool from "@editorjs/link";
import axios from "axios";
import wordsCount from 'words-count';
import showAlert from "/assets/common/message";

let editorContent;
let operationID = Date.parse( new Date()) + Math.random().toString(16).slice(2);
let coverImage;

const editor = new EditorJS({
  holder: "editorjs",
  placeholder: "Please enter the text",
  minHeight: 0,
  onChange: async (api, event) => {
    editorContent = await api.saver.save()
    if (editorContent.blocks !== []) {
      let wordsAmount = 0;
      editorContent.blocks.map((block) => {
        wordsAmount = wordsAmount + wordsCount(block.data.text)
      });

      document.querySelector('.number-words .numbers').innerText = wordsAmount;
    }
  },
  tools: {
    header: Header,
    list: {
      class: List,
      inlineToolbar: true,
    },
    image: {
      class: ImageTool,
      config: {
        uploader: {
          async uploadByFile(file) {
            let extension;
            if (file.type.indexOf("image/") === 0) {
              extension = file.type.replace("image/", "");
            }

            let params = new URLSearchParams({
              extension: extension,
              operationID: operationID,
            });
            const res = await axios.get("/file/getpresigned?" + params);

            const response = await fetch(res.data.preSignedURL, {
              method: 'PUT',
              body: file
            })

            let result = {
              success: 1,
              file: {
                url: res.data.getUrl
              }
            }
            return result;
          },
        },
      },
    },
    linkTool: {
      class: LinkTool,
    },
  },
});

document.querySelector('.up-or-down').addEventListener('click', function(e) {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
})

let imageUpload = document.querySelector('.uploadCover-input');
imageUpload.addEventListener('change', async function (e) {
  let file = this.files[0];
  if (file) {
    let extension;
    if (file.type.indexOf("image/") === 0) {
      extension = file.type.replace("image/", "");
    }

    let params = new URLSearchParams({
      extension: extension,
      operationID: operationID,
    })
    const res = await axios.get("/file/getpresigned?" + params);
    coverImage = res.data.getUrl;
    const response = await fetch(res.data?.preSignedURL, {
      method: 'PUT',
      body: file
    })

    /**
     * if upload image successfully, set cover preview
     */
    if (response.status === 200) {
      // if there is already a cover preview, just remove it.
      if (document.querySelector('.cover-preview') !== null) {
        document.querySelector('.cover-preview').remove();
      }

      document.querySelector('.uploadCover-wrapper').style.display = 'none';
      let template = `<div class="cover-preview">
      <img
        alt="封面图"
        src="${URL.createObjectURL(file)}"
        class="cover-preview-image"
      />
      <div class="cover-preview-buttonGroup">
        <button title="更换" type="button" class="Button" id="change-cover">更换</button>
        <div class="buttonGroup-seperator"></div>
        <button title="删除" type="button" class="Button" id="delete-cover">删除</button>
      </div>
    </div>`;
      document.querySelector('.post-cover div').insertAdjacentHTML('afterbegin', template);
      let coverPreview = document.querySelector('.cover-preview');
      let buttonGroup = document.querySelector('.cover-preview-buttonGroup');
      coverPreview.addEventListener('mouseover', function (e) {
        e.stopPropagation();
        buttonGroup.style.display = 'flex';
      });

      coverPreview.addEventListener('mouseleave', function (e) {
        buttonGroup.style.display = null;
      });

      document.getElementById('change-cover').addEventListener('click', function (e) {
        imageUpload.click();
      });

      /**
       * cover preview delete event
       */
      document.getElementById('delete-cover').addEventListener('click', function(e) {
        document.querySelector('.cover-preview').remove();
        document.querySelector('.uploadCover-wrapper').style.display = null;
      })
    } else {
      showAlert("Failed to upload image, please retry");
    }
  }
});

/**
 * press save button event handler
 */
document.getElementById('save').addEventListener('click', function(e) {
  let title = document.getElementById('title').value;
  let content;
  let postCategory;
  editor.save().then((outputData) => {
    content = outputData;
  }).catch((error) => {
    showAlert("Save editor failed");
  });

})
