// CustomEditor.js
import ClassicEditorBase from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
import Underline from '@ckeditor/ckeditor5-basic-styles/src/underline';
import Strikethrough from '@ckeditor/ckeditor5-basic-styles/src/strikethrough';
import FontColor from '@ckeditor/ckeditor5-font/src/fontcolor';
import FontBackgroundColor from '@ckeditor/ckeditor5-font/src/fontbackgroundcolor';
import FontSize from '@ckeditor/ckeditor5-font/src/fontsize';
import Table from '@ckeditor/ckeditor5-table/src/table';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar';
import Image from '@ckeditor/ckeditor5-image/src/image';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
import ImageResize from '@ckeditor/ckeditor5-image/src/imageresize';
import ImageUpload from '@ckeditor/ckeditor5-image/src/imageupload';

export default class ClassicEditor extends ClassicEditorBase {}

// Plugins to include in the build.
ClassicEditor.builtinPlugins = [
    Essentials, Paragraph, Bold, Italic, Underline, Strikethrough,
    FontColor, FontBackgroundColor, FontSize,
    Table, TableToolbar,
    Image, ImageToolbar, ImageResize, ImageUpload
];

// Editor configuration.
ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            'heading','|','bold','italic','underline','strikethrough','link',
            'bulletedList','numberedList','blockQuote','|',
            'fontSize','fontColor','fontBackgroundColor','|',
            'insertTable','tableColumn','tableRow','mergeTableCells','|',
            'uploadImage','imageTextAlternative','|',
            'undo','redo'
        ]
    },
    image: {
        toolbar: [
            'imageTextAlternative','imageStyle:alignLeft','imageStyle:alignRight','imageStyle:alignCenter','resizeImage:50','resizeImage:75','resizeImage:original'
        ]
    },
    table: {
        contentToolbar: ['tableColumn','tableRow','mergeTableCells','tableProperties','tableCellProperties']
    },
    language: 'en'
};
