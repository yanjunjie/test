// html to pdf function
function htmlToPdf(autoTableId='', fileName = '', headerHtmlId = '', footerHtmlId='', otherHtmlId = '' ) {
    //let doc = new jsPDF();
    let doc = new jsPDF('p', 'pt', 'a4', true);  //pt = px * .75

    let table = autoTableId ? ($("#"+autoTableId).get(0)) : document.getElementById("autoTableId");
    let newFileName = fileName ? (fileName + '.pdf') : 'report.pdf';
    let headerHtml = headerHtmlId ? ($("#"+headerHtmlId).get(0)) : document.getElementById("headerHtmlId");
    let footerHtml = footerHtmlId ? ($("#"+footerHtmlId).get(0)) : document.getElementById("footerHtmlId");
    let otherHtml = otherHtmlId ? ($("#"+otherHtmlId).get(0)) : document.getElementById("otherHtmlId");

    let startY = 30;
    let finalY = doc.previousAutoTable.finalY;
    let pageNumber = doc.internal.getNumberOfPages();
    doc.setPage(pageNumber);
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
        '#skipText': function (element,renderer) {
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
        //doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 20, 50, 50);
        /*if (base64Img) {
            doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
        }*/

        //let headerHtml = '<header>Hello Header</header>';

        //doc.text(headerHtml, data.settings.margin.left + 15, 22);
        doc.fromHTML(
            headerHtml,
            margins.mLeft, //x coord
            margins.mTop, //y coord
            otherContentOptions, //options object
            margins
        );
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
    };

    /*
    //doc.addPage();
    doc.setFont('RopaSans-Regular');
    doc.setFontType('normal');
    doc.setFontSize(11);
    doc.setTextColor(100);
    doc.text("From javascript arrays", 14, finalY + 15); // Text with margins
    doc.deletePage(1); // delete the first page
    */

    // Auto table content options
    let autoTableOptions = {
        html: table,
        startY: startY, //false
        //margin: {top: 30},
        theme: 'plain', //striped, plain, grid
        cellWidth: 'auto',
        useCss: true,
        //tableWidth: 'wrap',
        margin: {bottom:20},
        showHead: 'firstPage', //false, 'everyPage', 'firstPage'
        tableLineWidth: .75,
        tableLineColor: [0, 0, 0],
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
            overflow: 'linebreak', //visible, hidden, ellipsize or linebreak
            fontStyle: 'normal', //normal, bold, italic, bolditalic
            rowPageBreak: 'always', //always, auto, avoid
        },

        // Header & Footer
        didDrawPage: function (data) {
            // Header Content
            header(data);

            // Footer Content
            footer(data);
        },

        /*
        from documentation
        pageBreak: 'avoid', // always, avoid, auto
        cellWidth: 'wrap', // 20, auto
        bodyStyles: {valign: 'top'},
        styles: {cellWidth: 'wrap', rowPageBreak: 'auto', halign: 'justify', cellPadding: 0.5, fontSize: 8, overflow: 'ellipsize', overflow: 'hidden', overflow: 'linebreak', valign: 'middle', halign: 'center'},
        headStyles: { fillColor: [241, 196, 15], fontSize: 15 },
        footStyles: { fillColor: [241, 196, 15], fontSize: 15 },
        bodyStyles: { fillColor: [52, 73, 94], textColor: 240 },
        columnStyles: {0: {cellWidth: 50}, 1: {cellWidth: 'auto'}, text: {cellWidth: 'auto'}, fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold'}
        margin: {right: 107,left: 107},
        startY: doc.autoTable.previous.finalY + 10,
        alternateRowStyles: { fillColor: [74, 96, 117] },
        allSectionHooks: true,
        beforePageContent: header,
        startY: doc.autoTableEndPosY() + 20,
        var startingPage = doc.internal.getCurrentPageInfo().pageNumber;
        */
    };

    // Auto table content
    doc.autoTable(autoTableOptions);

    // Total page number
    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }

    // Other content
    /*doc.fromHTML(
        otherContent,
        margins.mLeft, //x coord
        margins.mTop, //y coord
        otherContentOptions, //options object
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
    htmlToPdf('table-id','newname');
});
