<?php

use App\Modules\Acesso\Controller\CadastroPageController;
use App\Modules\Acesso\Controller\CadastroPostPageController;
use App\Modules\Acesso\Controller\LoginPageController;
use App\Modules\Acesso\Controller\LogoutPageController;
use App\Modules\Album\Controller\AlbumAdicionarFotoPageController;
use App\Modules\Album\Controller\AlbumCriarPageController;
use App\Modules\Album\Controller\AlbumEditarPageController;
use App\Modules\Album\Controller\AlbumExcluirPageController;
use App\Modules\Album\Controller\AlbumIndexPageController;
use App\Modules\Album\Controller\AlbumPublicarFotoPageController;
use App\Modules\Album\Controller\AlbumPublicarPageController;
use App\Modules\Album\Controller\AlbumVisualizarPageController;
use App\Modules\Album\Controller\ThumbPageController;
use App\Modules\Amizade\Controller\AdicionarSeguidoresPageController;
use App\Modules\Amizade\Controller\AmizadeAceitarSolicitacaoPageController;
use App\Modules\Amizade\Controller\AmizadeBuscarPageController;
use App\Modules\Amizade\Controller\AmizadeDesfazerConvitePageController;
use App\Modules\Amizade\Controller\AmizadeIndexPageController;
use App\Modules\Amizade\Controller\AmizadeRecusarSolicitacaoPageController;
use App\Modules\Amizade\Controller\AmizadeRemoverPageController;
use App\Modules\Amizade\Controller\AmizadeSolicitarPageController;
use App\Modules\Amizade\Controller\AmizadeVerificarSolicitacaoPageController;
use App\Modules\Amizade\Controller\AmizadeVisualizarSolicitacaoPageController;
use App\Modules\Amizade\Controller\DeixarDeSeguirPerfilPageController;
use App\Modules\Amizade\Controller\SeguidoresPageController;
use App\Modules\Amizade\Controller\SeguindoPageController;
use App\Modules\Amizade\Controller\SeguirPerfilPageController;
use App\Modules\Enquete\Controller\EnqueteComentarPageController;
use App\Modules\Enquete\Controller\EnqueteCriarPageController;
use App\Modules\Enquete\Controller\EnqueteExcluirPageController;
use App\Modules\Enquete\Controller\EnqueteFinalizarPageController;
use App\Modules\Enquete\Controller\EnqueteIndexPageController;
use App\Modules\Enquete\Controller\EnquetePublicarPageController;
use App\Modules\Enquete\Controller\EnqueteVisualizarPageController;
use App\Modules\Enquete\Controller\EnqueteVotarPageController;
use App\Modules\Evento\Controller\EventoExcluirPageController;
use App\Modules\Evento\Controller\EventoFeedPageController;
use App\Modules\Evento\Controller\EventoIndexPageController;
use App\Modules\Evento\Controller\EventoPublicarPageController;
use App\Modules\Evento\Controller\EventoVisualizarPageController;
use App\Modules\Favorito\Controller\FavoritoAdicionarPageController;
use App\Modules\Favorito\Controller\FavoritoExcluirPageController;
use App\Modules\Favorito\Controller\FavoritoIndexPageController;
use App\Modules\Forum\Controller\ForumIndexPageController;
use App\Modules\Forum\Controller\TopicoCriarPageController;
use App\Modules\Forum\Controller\TopicoExcluirPageController;
use App\Modules\Forum\Controller\TopicoPublicarPageController;
use App\Modules\Forum\Controller\TopicoResponderPageController;
use App\Modules\Forum\Controller\TopicoUpdatePageController;
use App\Modules\Forum\Controller\TopicoVisualizarPageController;
use App\Modules\Index\Controller\IndexPageController;
use App\Modules\Itan\Controller\ItanEscreverPageController;
use App\Modules\Itan\Controller\ItanExcluirPageController;
use App\Modules\Itan\Controller\ItanIdVisualizarPageController;
use App\Modules\Itan\Controller\ItanIndexPageController;
use App\Modules\Itan\Controller\ItanOrisaPageController;
use App\Modules\Itan\Controller\ItanPublicarPageController;
use App\Modules\Itan\Controller\ItanVisualizarPageController;
use App\Modules\Mural\Controller\MensagemComentarPageController;
use App\Modules\Mural\Controller\MensagemCurtirPageController;
use App\Modules\Mural\Controller\MensagemPublicarPageController;
use App\Modules\Mural\Controller\MensagemVisualizarPageController;
use App\Modules\Mural\Controller\MuralIndexPageController;
use App\Modules\Perfil\Controller\PerfilViewPageController;
use App\Modules\Recado\Controller\RecadoExcluirPageController;
use App\Modules\Recado\Controller\RecadoIndexPageController;
use App\Modules\Recado\Controller\RecadoPublicarPageController;
use App\Modules\Recado\Controller\RecadoVerificarPageController;
use App\Modules\Recado\Controller\RecadoVisualizarPageController;
use Prime\Server\Routing\RouteCollection;

/*
  |-------------------------------------------------------------------------
  | RouteCollection
  |-------------------------------------------------------------------------
  |
  | Objeto no qual serão definidas as rotas utilizadas na aplicação
  |
 */
$routes = new RouteCollection();
/*
  |-------------------------------------------------------------------------
  | Rota para o método GET
  |-------------------------------------------------------------------------
  |
  | Define o local aonde serão armazenados os templates que serão utilizados na aplicação
  |
 */

/* * *****************************************************************************
 * HOME / INDEX
 * **************************************************************************** */
$routes->setGet('/', IndexPageController::class, 'index');


return $routes;
