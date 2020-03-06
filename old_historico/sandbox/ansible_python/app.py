
#coding:utf-8  

import os.path

#para o servidor
import tornado.locale 
import tornado.httpserver
import tornado.ioloop  
import tornado.options  
import tornado.web 
from tornado.options import define, options  

#para o output de dados
import json


#para ler o arquivo de configuracao
import ConfigParser, os

#banco de dados do frontend
import MySQLdb



define("port", default=8000, help="run on the given port", type=int)  

class InventarioHosts(tornado.web.RequestHandler):
        def post(self, *args, **kwargs):
		try:
			servidor = self.get_argument('grupo')
		except:
			servidor ="all"
                item=""
                corpo="{\"hosts\":["
		import os
		hosts=os.popen("ansible  "+servidor+" --list-hosts").read()
	        item=hosts.replace("\n","\",")	
		item=item.replace("    "," \"")
		#for options in hosts:
	       	#	item=item+" \""+options+"\","
		
                item=item[1:-1]
                corpo=corpo+item+"]}"
                self.set_header("Content-Type", "application/json")
                self.write(corpo);


class InventarioGrupos(tornado.web.RequestHandler):
	def post(self, *args, **kwargs):
		config = ConfigParser.ConfigParser()
        	config.readfp(open('/etc/ansible/hosts'))
        	item=""
        	corpo="{\"grupos\":["
        	for section in config.sections():
                	item=item+" \""+section+"\","
                item=item[1:-1]
        	corpo=corpo+item+"]}"
		self.set_header("Content-Type", "application/json")
		self.write(corpo);

class Api(tornado.web.RequestHandler):

	def post(self, *args, **kwargs):
		try:
			p_id = self.get_argument('id_procedimento')
			db=MySQLdb.connect('localhost', 'root', '@SENHA', 'ansible')
			con=db.cursor()
			sql=("""select 
						h.nome host, t.modulo modulo, IFNULL(t.argumento,"") argumento  
					from 
						procedimento p 
						inner join inventario_host h ON p.alvo=h.id 
						inner join tasks t on p.task_id = t.id 
					where 
						p.id=%d """ % int(p_id))
			con.execute(sql)
			result_set = con.fetchall ()
			for row in result_set:
				servidor=row[0]
				modulo=row[1]
				argumentos=row[2]
			
			self.set_header("Content-Type", "application/json")
			self.set_header("Access-Control-Allow-Origin", "*")
			
			import ansible.runner
			runner = ansible.runner.Runner(
						module_name = modulo,
						module_args = argumentos,
						pattern = servidor,
				)
			result = runner.run()
			
			
			
			
			def pars_result(result):
				if len(result['dark'])>0:
					return result['dark'],'ERRO!'
				else:
					return result['contacted'],'OK!'
					
			result = pars_result(result)
			#self.write(json.dumps(result[0], sort_keys=True, indent=4, separators=(',', ': ')),)
			retorno=json.dumps(result[0], sort_keys=True, indent=4, separators=(',', ': '))

			flag=json.loads(retorno)

			
			
			#MONTANDO O HTML DE RETORNO
			html="<h3>Procedimento executado!</h3>"
			html=html+"<br><b>Servidor:</b>"+servidor+"<br><b>Módulo:</b>"+modulo+"<br><b>Argumentos:</b>"+argumentos+"<br>"
			
			try:
				if (flag[servidor]['failed']==True):
					flag="error"
					html=html+"<p class='text-danger'><b>Atenção: O procedimento NÃO foi executado com sucesso! <br>Ocorreu falha!<br></b></p>"
			except:
				try:
					if (flag[servidor]):
						flag="result"
						html=html+"<p class='text-success'><b>O procedimento foi executado com sucesso!<br></b></p>"
				except:
					flag="error"
					html=html+"<p class='text-danger'><b>Atenção: O procedimento NÃO foi executado com sucesso! <br>Provavelmente não foi possível alcançar o servidor<br></b></p>"

			log="{ \""+str(flag)+"\": { \"message\" : \""+html+"<b>log:</b>:<br><pre>"+retorno.replace("\"", "").replace("\n","<br>")+"</pre>\" } }"
			con.close()
			self.write(log)
		except Exception, e:
				self.set_header("Content-Type", "application/json")
				self.set_header("Access-Control-Allow-Origin", "*")
				log="{ \"error\": { \"message\" : \""+html+"<b>log:</b>:<br><pre>"+str(e)+"</pre>\" } }"
				self.write(log)
		
class Application(tornado.web.Application):  
    def __init__(self):  
        handlers = [  
            (r"/", MainHandler),  
            (r"/index", MainHandler),    
            (r"/result", Module_actionHandler),  
	        (r"/executar", Api),
	        (r"/getGrupo",InventarioGrupos),
	        (r"/getHost",InventarioHosts),
  
        ]  
        settings = dict(  
            template_path=os.path.join(os.path.dirname(__file__), "templates"),  
            #static_path=os.path.join(os.path.dirname(__file__), "static"),  
            # ui_modules={"Book": BookModule},  
            debug=True,  
        )  

        tornado.web.Application.__init__(self, handlers, **settings)  

class MainHandler(tornado.web.RequestHandler):  
    def get(self):  
	config = ConfigParser.ConfigParser()
	config.readfp(open('/etc/ansible/hosts'))
	dropdown=""
        html="<html><head><title>Interface para executar </title></head><body><h1>Informe os argumentos abaixos:</h1><form method=\"post\" action=\"/result\"><p>Host/Grupo:<select name=\"pattern\">"
	for section in config.sections():
		dropdown=dropdown+" <option value=\""+section+"\">["+section+"]</option>"
    		for options in config.options(section):
			dropdown=dropdown+" <option value=\""+options.split()[0]+"\"> &nbsp; &nbsp; &nbsp;|-- "+options.split()[0]+"</option>"
	html=html+dropdown+"</select></p><p>Módulo<br><input type=\"text\" name=\"module_name\"></p><p>Argumentos<br><input type=\"text\" name=\"module_args\"></p><input type=\"submit\"></form></body></html>"

        self.write(html)  

class Module_actionHandler(tornado.web.RequestHandler):  
       
  
    def post(self, *args, **kwargs):  

        pattern = self.get_arguments('pattern')[0]  
        module_name = self.get_arguments('module_name')[0]  
        module_args = self.get_arguments('module_args')[0]  
        
        import ansible.runner  
        runner = ansible.runner.Runner(  
            module_name = module_name,  
            module_args = module_args,  
            pattern = pattern,  
        )  
        result = runner.run()  

	#conn = pymongo.Connection("localhost", 27017)
        #db = conn["ansible"] 
        #if type(result) == dict:
        #   db.ansible.insert(result)       
     
 
        def pars_result(result):  
            if len(result['dark'])>0:  
                return result['dark'],'ERRO!'  
            else:  
                return result['contacted'],'OK!'  
        result = pars_result(result)  

        self.render(  
            "result.html",  
            message = json.dumps(result[0], sort_keys=True, indent=4, separators=(',', ': ')),  
            result = result[1]  
        )  

if __name__ == "__main__":  
    tornado.options.parse_command_line()  
    http_server = tornado.httpserver.HTTPServer(Application())  
    http_server.listen(options.port)  
    tornado.ioloop.IOLoop.instance().start()
