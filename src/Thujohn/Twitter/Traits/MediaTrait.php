<?php namespace Thujohn\Twitter\Traits;

use Exception;

Trait MediaTrait {

	/**
	 * Upload media (images) to Twitter, to use in a Tweet or Twitter-hosted Card.
	 *
	 * Parameters :
	 * - media
	 */
	public function uploadMedia($parameters = [], $video = false)
	{
		if (!array_key_exists('media', $parameters))
		{
			throw new Exception('Parameter required missing : media');
		}
		
		if(!$video)
		return $this->post('media/upload', $parameters, true);
		else {
			
			$response = $this->post('media/upload', ['command' => 'INIT', 'media_type'=>'video/*', 'total_bytes' => strlen($parameters['media'])], true);
			
			$media_id = $response->media_id;
			$response = $this->post('media/upload', ['command' => 'APPEND', 'media_id'=>$media_id, 'segment_index' => '0', 'media' => $parameters['media']], true);
			
			return $this->post('media/upload', ['command' => 'FINALIZE', 'media_id'=>$media_id], true);
			
				
			}
		
	}

}
