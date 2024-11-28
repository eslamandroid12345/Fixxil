<?php

namespace App\Repository;

interface BlogRepositoryInterface extends RepositoryInterface
{
    public function getAllBlogs($is_published = false);

    public function getAllQuestions();
    public function getAllQuestionsDashboard();

    public function getBlogsForHome();

    public function getAllBlogsCount();

    public function getAllBlogsAdmin();
    public function getLastBlogs();
    public function getLastQuestions();


}
