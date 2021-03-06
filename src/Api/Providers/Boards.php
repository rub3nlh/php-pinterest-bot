<?php

namespace seregazhuk\PinterestBot\Api\Providers;

use seregazhuk\PinterestBot\Helpers\Providers\FollowHelper;
use seregazhuk\PinterestBot\Helpers\Providers\SearchHelper;
use seregazhuk\PinterestBot\Api\Request;
use seregazhuk\PinterestBot\Helpers\UrlHelper;

class Boards extends Provider
{
    use SearchHelper, FollowHelper;

    /**
     * Get boards for user by username
     * @param string $username
     * @return array|bool
     */
    public function forUser($username)
    {
        $get = Request::createRequestData(
            [
                'options' => ["username" => $username],
            ]
        );

        return $this->boardsGetCall($get, UrlHelper::RESOURCE_GET_BOARDS);
    }

    /**
     * Get info about user's board
     * @param string $username
     * @param string $board
     * @return array|bool
     */
    public function info($username, $board)
    {
        $get = Request::createRequestData(
            [
                'options' => [
                    'username'      => $username,
                    'slug'          => $board,
                    'field_set_key' => 'detailed'
                ],
            ]
        );

        return $this->boardsGetCall($get, UrlHelper::RESOURCE_GET_BOARDS);
    }

    /**
     * Get pins form board by boardId
     * @param int $boardId
     * @param int $batchesLimit
     * @return \Iterator
     */
    public function pins($boardId, $batchesLimit = 0)
    {
        return $this->getPaginatedData(
            [$this, 'getPinsFromBoard'], [
            'boardId' => $boardId,
        ], $batchesLimit
        );

    }

    /**
     * @param int   $boardId
     * @param array $bookmarks
     * @return array|bool
     */
    protected function getPinsFromBoard($boardId, $bookmarks = [])
    {
        $get = Request::createRequestData(
            [
                'options' => ['board_id' => $boardId],
            ], '', $bookmarks
        );

        return $this->boardsGetCall($get, UrlHelper::RESOURCE_GET_BOARD_FEED, true);
    }

    /**
     * Run GET api request to boards resource
     * @param array  $query
     * @param string $url
     * @param bool   $pagination
     * @return array|bool
     */
    protected function boardsGetCall($query, $url, $pagination = false)
    {
        $getString = UrlHelper::buildRequestString($query);
        $response = $this->request->exec($url."?{$getString}");
        if ($pagination) {
            return $this->response->getPaginationData($response);
        }

        return $this->response->getData($response);
    }

    protected function getScope()
    {
        return 'boards';
    }

    protected function getEntityIdName()
    {
        return Request::BOARD_ENTITY_ID;
    }

    protected function getFollowUrl()
    {
        return UrlHelper::RESOURCE_FOLLOW_BOARD;
    }

    protected function getUnfFollowUrl()
    {
        return UrlHelper::RESOURCE_UNFOLLOW_BOARD;
    }
}