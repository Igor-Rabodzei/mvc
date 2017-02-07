<?php

include_once ROOT.'/models/News.php';

class HivesController
    {
        public function actionIndex()
            {
                $newsList = array();
                $newsList = News::getNewsList();

                require_once(ROOT . '/views/news/index.php');

                return true;

//                echo '<pre>';
//                print_r($newsList);
//                echo '<pre>';

                return true;
            }

            public function actionView($id){
                if($id){
                    $newsItem = News::getNewsItemByID($id);

                    var_dump($id);
                    require_once(ROOT . '/views/news/view.php');

                    echo  '<pre>';
                    print_r($newsItem);
                    echo '<pre>';

                    echo 'actionView';
                }

                return true;
            }
    }