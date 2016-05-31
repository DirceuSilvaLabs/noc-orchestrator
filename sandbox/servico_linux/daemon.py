#!/usr/bin/env python
# coding: utf-8

import os
import sys
import time
import atexit
import logging
import signal


class Daemon(object):
    """
    Classe genérica para criar um serviço (linux - daemon)

    Usage: subclass the Daemon class and override the run() method
    """

    def __init__(self, pidfile, stdin='/dev/null',
                 stdout='/dev/null', stderr='/dev/null'):
        self.stdin = stdin
        self.stdout = stdout
        self.stderr = stderr
        self.pidfile = pidfile

    def daemonize(self):
        """
        do the UNIX double-fork magic, see Stevens' "Advanced 
        Programming in the UNIX Environment" for details (ISBN 0201563177)
        http://www.erlenstar.demon.co.uk/unix/faq_2.html#SEC16
        """
        # Do first fork
        self.fork()

        # Decouple from parent environment
        self.dettach_env()

        # Do second fork
        self.fork()

        # Flush standart file descriptors
        sys.stdout.flush()
        sys.stderr.flush()

        # 
        self.attach_stream('stdin', mode='r')
        self.attach_stream('stdout', mode='a+')
        self.attach_stream('stderr', mode='a+')
       
        # write pidfile
        self.create_pidfile()

    def attach_stream(self, name, mode):
        """
        Replaces the stream with new one
        """
        stream = open(getattr(self, name), mode)
        os.dup2(stream.fileno(), getattr(sys, name).fileno())

    def dettach_env(self):
        os.chdir("/")
        os.setsid()
        os.umask(0)

    def fork(self):
        """
        Spawn the child process
        """
        try:
            pid = os.fork()
            if pid > 0:
                sys.exit(0)
        except OSError as e:
            sys.stderr.write("Não foi possivel realizar fork no processo: %d (%s)\n" % (e.errno, e.strerror))
            sys.exit(1)

    def create_pidfile(self):
        atexit.register(self.delpid)
        pid = str(os.getpid())
        open(self.pidfile,'w+').write("%s\n" % pid)

    def delpid(self):
        """
        Removendo o arquivo de pid
        """
        os.remove(self.pidfile)

    def start(self):
        """
        Start the daemon
        """
        # Check for a pidfile to see if the daemon already runs
        pid = self.get_pid()

        if pid:
            message = "pidfile %s already exist. Daemon already running?\n"
            sys.stderr.write(message % self.pidfile)
            sys.exit(1)

        # Start the daemon
        self.daemonize()
        self.run()

    def get_pid(self):
        """
        Returns the PID from pidfile
        """
        try:
            pf = open(self.pidfile,'r')
            pid = int(pf.read().strip())
            pf.close()
        except (IOError, TypeError):
            pid = None
        return pid

    def stop(self, silent=False):
        """
        Stop the daemon
        """
        # Get the pid from the pidfile
        pid = self.get_pid()

        if not pid:
            if not silent:
                message = "pidfile %s does not exist. Daemon not running?\n"
                sys.stderr.write(message % self.pidfile)
            return # not an error in a restart

        # Try killing the daemon process    
        try:
            while True:
                os.kill(pid, signal.SIGTERM)
                time.sleep(0.1)
        except OSError as err:
            err = str(err)
            if err.find("No such process") > 0:
                if os.path.exists(self.pidfile):
                    os.remove(self.pidfile)
            else:
                sys.stdout.write(str(err))
                sys.exit(1)

    def restart(self):
        """
        Restart the daemon
        """
        self.stop(silent=True)
        self.start()

    def run(self):
        """
        You should override this method when you subclass Daemon. It will be called after the process has been
        daemonized by start() or restart().
        """
        raise NotImplementedError


class MyDaemon(Daemon):
    def run(self):
        print("Começando a brincadeira")
        while True:
            time.sleep(0.1)
            print(time.time())
            print ("Aguardando para processar....")


def main():
    """
    Ponto de entrada da aplicação
    """
    nomeServico="Servico teste"

    import gettext 
    def convertArgparseMessages(s):
        subDict = \
        {'positional arguments':'Argumentos obrigatórios',
        'optional arguments':'Argumento opcional',
        'show this help message and exit':'Apresenta esta mensagem de ajuda e sai... :)',
        'invalid choice':'opção inválida'}
        if s in subDict:
            s = subDict[s]
        return s
    gettext.gettext = convertArgparseMessages
    import argparse
    
    parser = argparse.ArgumentParser(
        #prog='PROG',
        description=nomeServico,
        epilog="Uma iniciativa INAP-labs (https://github.com/INAP-LABS)"
    )

    parser.add_argument('operacao',
                    type=str,
                    help='Opção desconhecida. Valores de argmento conhecidos são: start, stop, restart, status',
                    choices=['start', 'stop', 'restart', 'status'])

    args = parser.parse_args()
    operacao = args.operacao

    # Daemon
    daemon = MyDaemon('/tmp/python.pid',stdin='/dev/null',stdout='/tmp/out.log', stderr='/tmp/err.log')
    if operacao == 'start':
        print("Starting daemon")
        daemon.start()
        pid = daemon.get_pid()

        if not pid:
            print("O serviço não está rodando - nada feito (Não foi localizado o PID do processo!)")
        else:
            print("Serviço rodando [PID=%d]" % pid)

    elif operacao == 'stop':
        print("Parando o serviço")
        daemon.stop()

    elif operacao == 'restart':
        print("Reiniciando o serviço")
        daemon.restart()
    elif operacao == 'status':
        print("Verificando o status do serviço")
        pid = daemon.get_pid()

        if not pid:
            print("Serviço não está sendo executado ;)")
        else:
            print("Serviço executando [PID=%d]" % pid)

    sys.exit(0)

if __name__ == '__main__':
    main()
