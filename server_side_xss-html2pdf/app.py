from flask import Flask, render_template, request, make_response
from weasyprint import HTML
import hashlib

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/generate_pdf', methods=['POST'])
def generate_pdf():
    html_content = request.form['html_input']
    html = HTML(string=html_content)
    pdf = html.write_pdf()
    filename = hashlib.md5(html_content.encode('utf-8')).hexdigest() + '.pdf'
    response = make_response(pdf)
    response.headers['Content-Type'] = 'application/pdf'
    response.headers['Content-Disposition'] = 'inline; filename='+filename
    return response
if __name__ == '__main__':
    app.run()
