from flask import Blueprint, render_template, request, redirect, url_for, flash, session

auth = Blueprint('auth', __name__)

@auth.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        qr_code = request.form.get('qr-code')
        
        # Contoh logika autentikasi sederhana
        if qr_code == "valid_qr_code":
            flash('Login successful!', 'success')
            return redirect(url_for('home'))
        else:
            session['gagal'] = True
            flash('Failed to proceed to the next step. Please try again.', 'danger')
            return redirect(url_for('auth.login'))

    return render_template('auth/login.html')
