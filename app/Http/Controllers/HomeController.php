<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function capturar()
    {
        return view('capturar',['artigos'=>0]);
    }

    public function exibir()
    {
        $registros = DB::table('artigos')->where('id_usuario',Auth::id())->orderBy('nome', 'asc')->get();
        return view('exibir',compact('registros'));
    }

    public function delete($id)
   {
        DB::table('artigos')->where('id', $id)->where('id_usuario',Auth::id())->delete();
       //return view('exibir');
       return redirect('/exibir');
       
    }

   

    public function capturardados(Request $req){
        $dados = $req->all();

        if (trim($dados['busca'])!= ''){

            $url = "https://www.questmultimarcas.com.br/estoque?termo=".$dados['busca'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $resultado = curl_exec($ch);

            $regex = '/<h2 class="card__title ui-title-inner"><a href="(?<link>[^"]+)">(?<nome>[^<]+)<\/a><\/h2>/i';
            preg_match_all($regex, $resultado, $matches);
            $carros['link'] = $matches['link'];
            $carros['nome'] = $matches['nome'];

            $regexid = '/<article class="card clearfix" id="(?<id>[^"]+)">/i';
            preg_match_all($regexid, $resultado, $matchesid);
            $carros['id'] = $matchesid['id'];

            $dados = ['Ano','Quilometragem','Combustível','Câmbio','Portas','Cor'];
            $regexdados = '/<span class="card-list__title">\n*\s*\n*\s*DADOS: <\/span>\n*\s*\n*\s*<span class="card-list__info">\n*\s*\n*\s*(?<dado>[^<]+)<\/span>/i';
            foreach ($dados as $dado) {
                preg_match_all(str_replace("DADOS",$dado,$regexdados),$resultado,$matches2);
                $carros[$dado] = $matches2['dado'];
            }

            $regexpreco = '/<div class="card__price">PREÇO:<span class="card__price-number">&#082;&#036;\s(?<preco>[^>]+)<span class="after-price-text"><\/span><\/span><\/div>/i';
            preg_match_all($regexpreco, $resultado, $matches3);
            $carros['preco'] = $matches3['preco'];

            $regeximg = '/<img width="\w+" height="\w+" src="(?<img>[^"]+)/i';
            preg_match_all($regeximg, $resultado, $matchesimg);
            $carros['img'] = $matchesimg['img'];

            $query =    "INSERT INTO artigos (id,id_usuario,img,link,nome,ano,km,combustivel,cambio,portas,cor,preco) ".
            "VALUES (**id**,".Auth::id().",'**img**','**link**','**nome**',**ano**,**km**,'**combustivel**','**cambio**','**portas**','**cor**',**preco**) ".
            "ON DUPLICATE KEY UPDATE ".
            "img = VALUES(img), ".
            "link = VALUES(link), ".
            "nome = VALUES(nome), ".
            "ano = VALUES(ano), ".
            "km = VALUES(km), ".
            "combustivel = VALUES(combustivel), ".
            "cambio = VALUES(cambio), ".
            "portas = VALUES(portas), ".
            "cor = VALUES(cor), ".
            "preco = VALUES(preco) ";

            foreach($carros['id'] as $key => $link) {
                $queryOk = str_replace(['**id**','**img**','**link**','**nome**','**ano**','**km**','**combustivel**','**cambio**','**portas**','**cor**','**preco**'],
                [$carros['id'][$key],$carros['img'][$key],$carros['link'][$key],$carros['nome'][$key],$carros['Ano'][$key],str_replace('.','',$carros['Quilometragem'][$key]),$carros['Combustível'][$key],$carros['Câmbio'][$key],$carros['Portas'][$key],$carros['Cor'][$key],str_replace('.','',$carros['preco'][$key])],
                $query);
                $inserted = DB::unprepared($queryOk);
            }

            $artigos = count($carros['id']);
            return view('capturar',['artigos'=>$artigos]);
        }

   

    }
}
