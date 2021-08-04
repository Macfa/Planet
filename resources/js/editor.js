// const ClassicEditor = require("@ckeditor/ckeditor5-build-classic/build/ckeditor.js");
require("../../ckeditor5/packages/ckeditor5-build-classic/build/ckeditor.js");
// import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';

const UploadAdapter = require('./uploadAdapter.js');
// alert('editor');

ClassicEditor
    .create( document.querySelector( '#editor' ), {
    // plugins: [ MediaEmbed ],
    // builtInPlugins: [MediaEmbed],
    // extraPlugins: [MyCustomUploadAdapterPlugin],

    // Enable the CKFinder button in the toolbar.
    toolbar: ["blockQuote", "bold", "imageTextAlternative", "mediaEmbed", "link", "ckfinder", "selectAll", "undo", "redo", "heading", "resizeImage:original", "resizeImage", "imageResize", "imageStyle:full", "imageStyle:side", "uploadImage", "imageUpload", "indent", "outdent", "italic", "numberedList", "bulletedList", "mediaEmbed", "insertTable", "tableColumn", "tableRow", "mergeTableCells"],
    // mediaEmbed: {
    //     providers: [
    //         {
    //              name: 'myProvider',
    //              url: /^example\.com\/media\/(\w+)/,
    //              html: match => '...'
    //         },
    //     ],
    //     previewsInData: true
    // },
} )
.then(editor => {
    console.log(editor);
    // console.log( Array.from( editor.ui.componentFactory.names() ) );
})
.catch( error => {
    console.error( error );
} );

// function MyCustomUploadAdapterPlugin(editor) {
//     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
//         return new UploadAdapter(loader)
//     }
// }

