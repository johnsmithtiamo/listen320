<?php

namespace Song\Model;

interface SongCommandInterface {

    public function insertSong(Song $song);

    public function updateSong(Song $songNew, Song $songOld = null);

    public function deleteSong(Song $song);
}
