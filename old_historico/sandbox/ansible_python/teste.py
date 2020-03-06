
import urllib
params = {
              "alvo": "teste",
              "modulo": "ping",
              "argumentos": "",

         }
query = urllib.urlencode(params)
url = "http://127.0.0.1:8000/executar"
f = urllib.urlopen(url, query)
contents = f.read()
f.close()
print contents



params = {
              "alvo": "teste",
              "modulo": "ping",
              "argumentos": "",

         }
query = urllib.urlencode(params)
url = "http://127.0.0.1:8000/getGrupo"
f = urllib.urlopen(url, query)
contents = f.read()
f.close()
print contents


params = {
              "grupo": "all"

         }
query = urllib.urlencode(params)
url = "http://127.0.0.1:8000/getHost"
f = urllib.urlopen(url, query)
contents = f.read()
f.close()
print contents


