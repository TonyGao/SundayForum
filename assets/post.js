import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/list";
import ImageTool from "@editorjs/image";
import LinkTool from "@editorjs/link";
import axios from "axios";

const editor = new EditorJS({
    holder: "editorjs",
    placeholder: "Please enter the text",
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
                            extension: extension
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