// html to pdf function
function htmlToPdf(autoTableId='', fileName = '', headerHtmlId = '', footerHtmlId='', otherHtmlId = '' ) {
    //let doc = new jsPDF();
    let doc = new jsPDF('p', 'pt', 'a4', true);  //pt = px * .75

    let table = autoTableId ? ($("#"+autoTableId).get(0)) : document.getElementById("autoTableId");
    let newFileName = fileName ? (fileName + '.pdf') : 'report.pdf';
    let headerHtml = headerHtmlId ? ($("#"+headerHtmlId).get(0)) : document.getElementById("headerHtmlId");
    let footerHtml = footerHtmlId ? ($("#"+footerHtmlId).get(0)) : document.getElementById("footerHtmlId");
    let otherHtml = otherHtmlId ? ($("#"+otherHtmlId).get(0)) : document.getElementById("otherHtmlId");

    let startY = 300;
    let finalY = doc.previousAutoTable.finalY;
    /*let pageNumber = doc.internal.getNumberOfPages();
    doc.setPage(pageNumber);*/
    let totalPagesExp = "{total_pages_count_string}";

    // Document default options
    doc.autoTableSetDefaults({
        //headStyles: {fillColor: [155, 89, 182]}, // Purple, fillColor: 0
        //margin: {top: 25},
    });

    // Document margin list
    let margins = {mTop: 10, mBottom: 60, mLeft: 50, pTop: 10, pBottom: 60, pLeft: 50, width: 800};

    // Skip elements instead of display: none
    let specialElementHandlers = {
        '#skipElement': function (element,renderer) {
            return true;
        }
    };

    // Other content options
    let otherContentOptions = {
        'width': margins.width, //max width of content on PDF
        'elementHandlers': specialElementHandlers,
        'pagesplit': true,
    };

    // Header content options
    let header = function(data) {
        doc.setFontSize(18);
        doc.setTextColor(40);
        doc.setFontStyle('normal');

        headerHtml = '<div id="canvas" style="text-align: center;">' +
                        '<p>Main Header Main Header Main Header Main Header</p> ' +
                        '<p>Second Header</p>' +
                        '<p>Third Header</p>' +
                    '</div>';
        let pdfWidth = doc.internal.pageSize.getWidth();
        //let textWidth = doc.getTextWidth(headerHtml);
        //var imgData='';
        /*html2canvas($("#aca_tbl_header")[0], {
            useCORS : true,
            onrendered: function(canvas) {
                var imgData = canvas.toDataURL(
                    'image/png');
                //var doc = new jsPDF('p', 'mm');
                doc.addImage(imgData, 'PNG', 10, 10);
                doc.save('sample-file.pdf');
            }
        });*/

        //doc.addImage(imgData, 'JPEG', 10, 10); //JPEG

        html2canvas(document.querySelector('#aca_tbl_header'),
            {scale: 1}
        ).then(canvas => {
            let pdf = new jsPDF('p', 'pt');
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 10);
            pdf.save('report.pdf');
        });


        /*doc.fromHTML(
            headerHtml,
            pdfWidth/2, //x coord
            10, //y coord
            {
                useCss: true,
                margin: {left:0, right: 0},
                textAlign: "center"
            }
        );*/
    };

    // Footer content options
    let footer = function(data) {
        let str = "Page " + doc.internal.getNumberOfPages();

        // Total page number plugin only available in jspdf v1.0+
        if (typeof doc.putTotalPages === 'function') {
            str = str + " of " + totalPagesExp;
        }
        doc.setFontSize(10);

        // jsPDF 1.4+ uses getWidth, <1.4 uses .width
        let pageSize = doc.internal.pageSize;
        let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
        doc.text(str, data.settings.margin.left, pageHeight - 10);

        // Total page number
        if (typeof doc.putTotalPages === 'function') {
            doc.putTotalPages(totalPagesExp);
        }
    };

    // Auto table content options
    let autoTableOptions = {
        html: table,
        startY: 100, //false
        //margin: {top: 30},
        theme: 'plain', //striped, plain, grid
        cellWidth: 'auto',
        useCss: true,
        //tableWidth: 'wrap',
        margin: {bottom:20},
        showHead: 'everyPage', //false, 'everyPage', 'firstPage'
        //tableLineWidth: .75,
        //tableLineColor: [0, 0, 0],
        styles: {
            fontSize: 10.5, //14px
            font: 'helvetica', //helvetica, times, courier
            lineColor: [0, 0, 0], //or single value ie. lineColor: 255,
            lineWidth: .75, //1px
            cellPadding: 1.5,
            textColor: [0, 0, 0],
            fillColor: [255, 255, 255], //false for transparent or number or array of number
            valign: 'middle', //top, middle, bottom
            halign: 'left', //left, center, right
            cellWidth: 'auto', //'auto', 'wrap' or a number
            overflow: 'visible', //visible, hidden, ellipsize or linebreak
            fontStyle: 'normal', //normal, bold, italic, bolditalic
            rowPageBreak: 'always', //always, auto, avoid
            useCss: true,
        },

        // Header & Footer
        didDrawPage: function (data) {
            // Header Content
            //let pageNumber = doc.internal.getNumberOfPages();
            if(data.pageNumber === 1) {
                header(data);
            }

            // Footer Content
            footer(data);
        },
    };

    // Auto table with header content and footer page number
    doc.autoTable(autoTableOptions);

    // Footer content
    /*doc.fromHTML(
        footerHtml,
        margins.mLeft, //x coord
        margins.mTop, //y coord
       // otherContentOptions, //options object
        margins
    );*/


    // Output
    //doc.save(newFileName);
    doc.output("dataurlnewwindow");
}

// click handler
$('#export').click(function (e) {
    e.preventDefault();
    //let otherHtml = $('#otherContent').get(0);
    htmlToPdf('table-id','newname', 'aca_tbl_header', 'aca_tbl_footer');
});