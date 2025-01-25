from flask import Flask
from auth.routes import auth

app = Flask(__name__)
app.secret_key = 'your_secret_key'

# Register Blueprints
app.register_blueprint(auth, url_prefix='/auth')

@app.route('/')
def home():
    return "Welcome to the Home Page!"

if __name__ == '__main__':
    app.run(debug=True)
