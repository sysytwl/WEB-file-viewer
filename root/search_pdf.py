# -*- coding: utf-8 -*-

from pdfminer.pdfparser import PDFParser,PDFDocument
from pdfminer.pdfinterp import PDFResourceManager,PDFPageInterpreter
from pdfminer.converter import PDFPageAggregator
from pdfminer.layout import LTTextBoxHorizontal,LAParams
from pdfminer.pdfinterp import PDFTextExtractionNotAllowed

def parsePDFtoTXT(pdf_path):
    fp = open(pdf_path, 'rb')
    parser = PDFParser(fp)  
    document= PDFDocument()
    parser.set_document(document)
    document.set_parser(parser)
    document.initialize()
    if not document.is_extractable:
        raise PDFTextExtractionNotAllowed
    else:
        rsrcmgr=PDFResourceManager()
        laparams=LAParams()
        device=PDFPageAggregator(rsrcmgr,laparams=laparams)
        interpreter=PDFPageInterpreter(rsrcmgr,device)
        for page in document.get_pages():
            interpreter.process_page(page)
            layout=device.get_result()
            print(layout)
            output=str(layout)
            for x in layout:
                if (isinstance(x,LTTextBoxHorizontal)):
                    text=x.get_text()
                    output+=text
            with open('C:\\Users\\user\\Desktop\\pdfoutput.txt','a',encoding='utf-8') as f:
                f.write(output)

def get_word_page(word_list):
    f=open('C:\\Users\\user\\Desktop\\pdfoutput.txt',encoding='utf-8')
    text_list=f.read().split('<LTPage')
    n=len(text_list)
    for w in word_list:
        page_list=[]
        for i in range(1,n):
            if w in text_list[i]:
                page_list.append(i)
        with open('C:\\Users\\user\\Desktop\\result.txt','a',encoding='utf-8') as f:
                f.write(w+str(page_list)+'\n')
                
if __name__=='__main__':
    parsePDFtoTXT('C:\\Users\\user\\Desktop\\群体药动学原理建立卡马西平和丙戊酸的定时定量给药模型及临床应用_林玮玮.pdf')
    get_word_page(['群体药动学','服药时间','知情同意书','NONMEM','贝叶斯反馈'])