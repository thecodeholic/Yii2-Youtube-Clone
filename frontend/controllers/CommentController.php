<?php
/**
 * User: TheCodeholic
 * Date: 11/12/2020
 * Time: 8:58 AM
 */

namespace frontend\controllers;


use common\models\Comment;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CommentController
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package frontend\controllers
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'content' => [
                'class' => ContentNegotiator::class,
                'only' => ['create', 'update', 'delete', 'reply', 'by-parent', 'pin'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionCreate()
    {
        $comment = new Comment();
        if ($comment->load(\Yii::$app->request->post(), '') && $comment->save()) {
            return [
                'success' => true,
                'comment' => $this->renderPartial('@frontend/views/video/_comment_item', [
                    'model' => $comment,
                ])
            ];
        }

        return [
            'success' => false,
            'errors' => $comment->errors
        ];
    }

    public function actionDelete($id)
    {
        $comment = $this->findModel($id);
        if ($comment->belongsTo(\Yii::$app->user->id)) {
            $comment->delete();

            return ['success' => true];
        }
        throw new ForbiddenHttpException();
    }

    public function actionUpdate($id)
    {
        $comment = $this->findModel($id);
        if ($comment->belongsTo(\Yii::$app->user->id)) {
            $commentText = \Yii::$app->request->post('comment');
            $comment->comment = $commentText;
            if ($comment->save()) {
                return [
                    'success' => true,
                    'comment' => $this->renderPartial('@frontend/views/video/_comment_item', [
                        'model' => $comment,
                    ])
                ];
            }

            return [
                'success' => false,
                'errors' => $comment->errors
            ];
        }
        throw new ForbiddenHttpException();
    }

    public function actionReply()
    {
        $parentId = \Yii::$app->request->post('parent_id');
        $parentComment = $this->findModel($parentId);

        $comment = new Comment();
        $comment->comment = \Yii::$app->request->post('comment');
        $comment->video_id = $parentComment->video_id;
        $comment->parent_id = $parentId;
        if ($comment->save()) {
            return [
                'success' => true,
                'comment' => $this->renderPartial('@frontend/views/video/_comment_item', [
                    'model' => $comment,
                ])
            ];
        }

        return [
            'success' => false,
            'errors' => $comment->errors
        ];
    }

    public function actionByParent($id)
    {
        $parentComment = $this->findModel($id);

        $finalContent = "";
        foreach ($parentComment->comments as $comment) {
            $finalContent .=  $this->renderPartial('@frontend/views/video/_comment_item', [
                'model' => $comment,
            ]);
        }

        return [
            'success' => true,
            'comments' => $finalContent
        ];
    }

    public function actionPin($id)
    {
        $comment = $this->findModel($id);
        if ($comment->video->belongsTo(\Yii::$app->user->id)) {
            if ($comment->pinned){
                $comment->pinned = 0;
            } else {
                Comment::updateAll(['pinned' => 0], ['video_id' => $comment->video]);
                $comment->pinned = 1;
            }
            if ($comment->save()) {
                return [
                    'success' => true,
                    'comment' => $this->renderPartial('@frontend/views/video/_comment_item', [
                        'model' => $comment,
                    ])
                ];
            }
            return [
                'success' => false,
                'errors' => $comment->errors
            ];
        }

        throw new ForbiddenHttpException();
    }

    protected function findModel($id)
    {
        $comment = Comment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException;
        }

        return $comment;
    }
}