<?php 
/**
 * IMG PHP UPLOAD
 * PHP Version >=7.0
 *
 * @see       https://github.com/kdesignbrasil/img-upload 
 *
 * @author    Leandro G. dos Anjos
 * @author    Kethelyn Cris Pancier    
 */

namespace UploadLeandro;

class Upload
{
    /**
    * Recebe o(s) arquivo(s) para upload
    *
    * @var array
    */
    private $files; 

    /**
    * Limete de tamanho do arquivo
    *
    * @var int
    */
    private $size;

    /**
    * Diretorio que vai receber os arquivos de upload
    *
    * @var string
    */
    private $dir;

    /**
    * Set arquivos
    *
    * @param array $files return erro se não houver arquivos
    */
    public function __construct(array $files)
    {
        if(isset($files)){
            $this->files = $files;
        }else{
            return 'ERRO: Nenhum arquivo selecionado';
        }        
    } 

    /**
    * Set tamanho de arquivos
    *
    * @param int $size
    */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
    * Set diretorio de upload dos arquivos
    *
    * @param string $dir
    */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
    * Get tamanho arquivo
    *
    * @return int com tamanho de arquivo permitidos
    */
    private function getSize()
    {
        return $this->size;
    }

    /**
    * Get diretorio
    *
    * @return string com onde os arquivos serão salvos
    */
    private function getDir()
    {
        return $this->dir;
    }

    /**
    * Get total de arquivos
    *
    * @return int com total de arquivos selecionados
    */
    public function totalFiles()
    {
        $totalFiles = count($this->files['name']);
        return $totalFiles;
    }  

    /**
    * Get codigo unico
    *
    * @return int codigo unico para renomear arquivo
    */
    private function getUniqid()
    {
        return md5(uniqid(rand(), true)) . '.';
    }

    /**
    * Retorna lista de nomes de arquivos do upload
    * Essa lista pode ser salva no seu banco de dados 
    *
    * @return array
    */
    private function upload()
    {   
        $suporteIMG = array (IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $errorFiles  = array();
        for ($i=0; $i < $this->totalFiles(); $i++) {   
            $tmpEX = explode('.', $this->files['name'][$i]);
            $ext = end($tmpEX);    
            $nome_final =  $this-> getUniqid(). $ext;  
           if($this->getSize() >= $this->files['size'][$i] && in_array($this->files['type'][$i] , array('image/gif','image/jpeg', 'image/jpg', 'image/png'))):
                if(move_uploaded_file($this->files['tmp_name'][$i], $this->getDir(). '/' . $nome_final )):
                    array_push($errorFiles, $nome_final."|");
                endif;
                if (!in_array(  exif_imagetype($this->getDir(). '/' .$nome_final) , $suporteIMG) ) : 
                    // Caso o cabeçalho arquivo esteja alterado o mesmo é removido imediatamente da pasta de upload
                    unlink($nome_final);
                endif;  
           endif; 
        }
        return $errorFiles;
    }

    /**
    * Inicia o upload
    *
    * @return array
    */
    public function startUpload()
    {
       return $this->upload();
    }
}