<?php

namespace Song\Model;

interface SongRepositoryInterface {

    public function findAllSongs();

    public function findSong($song_id);
}
