<?php

if ( !function_exists( "ideal_get_client_ip" ) )
{
	/**
	 * @return mixed|string
	 */
	function ideal_get_client_ip()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ip_address = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ip_address = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ip_address = $_SERVER['REMOTE_ADDR'];
		else
			$ip_address = 'UNKNOWN';
		return $ip_address;
	}
}

if ( !function_exists( "ideal_insert_images_details" ) )
{
	/**
	 * @param array $args
	 *
	 * @return array|mixed
	 */
	function ideal_insert_images_details( array $args = [] )
	{
		$option_name = "ideal_images_details";
		$options = get_option( $option_name );
		if ( empty( $options ) )
		{
			$options = [];
			$id = 0;
		} else {
			$options = unserialize( $options );
			$id = end( $options );
			$id = $id['id'];
		}
		$id++;
		$option = [
			"id"    =>  $id,
			"name"     =>  $args['name'],
			"image"    =>  $args['image'],
		];
		array_push( $options, $option );
		$options = serialize( $options );
		update_option( $option_name, $options );
		return $options;
	}
}

if ( !function_exists( "ideal_get_all_images" ) )
{
	/**
	 * @return mixed
	 */
	function ideal_get_all_images()
	{
		$option_name = "ideal_images_details";
		$options = get_option($option_name);
		$options = unserialize($options);
		return $options;
	}
}

if ( !function_exists( "ideal_remove_image_by_id" ) )
{
	/**
	 * @param string $id
	 */
	function ideal_remove_image_by_id( string $id )
	{
		$images = ideal_get_all_images();

		foreach ( $images as $image )
		{
			if ( $image['id'] == $id )
			{
				unset($image);
			} else {
				$options[] = $image;
			}
		}

		if (empty($options))
		{
			$options = "";
		} else {
			$options = serialize($options);
		}

		update_option( "ideal_images_details", $options );
	}
}

if ( !function_exists( "ideal_get_images_by_id" ) )
{
	/**
	 * @param string $id
	 *
	 * @return mixed|string
	 */
	function ideal_get_images_by_id( $id )
	{
		$images = ideal_get_all_images();
		foreach ($images as $image)
		{
			if ($image['id'] == $id)
			{
				return $image;
			}
		}

		return "No Image Found";
	}
}

if ( !function_exists( "ideal_insert_images_to_tournament" ) )
{
	/**
	 * @param array $args
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	function ideal_insert_images_to_tournament(array $args = [], $title = "")
	{
		$option_name = "ideal_tournament";
		$options = get_option( $option_name );
		if (empty($options))
		{
			$options = [];
			$id = 0;
		} else {
			$options = unserialize($options);
			$id = end($options)['id'];
		}
		$id++;

		$option = [
			"id"    =>  $id,
			"title" =>  $title,
			"name"  =>  $args['name'],
			"image" =>  $args['image']
		];
		array_push( $options, $option );
		$options = serialize($options);
		update_option( $option_name, $options );
		return $options;
	}
}

if ( !function_exists( "ideal_get_all_tournament" ) )
{
	/**
	 * @return mixed
	 */
	function ideal_get_all_tournament()
	{
		$option_name = "ideal_tournament";
		$options = get_option( $option_name );
		$options = unserialize($options);
		return $options;
	}
}

if ( !function_exists( "ideal_create_tournament" ) )
{
	/**
	 * @param $key
	 * @param $title
	 *
	 * @return array
	 */
	function ideal_create_tournament( $key, $title )
	{
		$tournament = ideal_get_tournament_by_title( $title );
		$t1 = @$tournament[$key];
		$key++;
		$t2 = @$tournament[$key];
		$key++;
		return [ "i"	=> $key, "data" => [
			$t1, $t2
		] ];
	}
}

if ( !function_exists( "ideal_get_tournament_by_title" ) )
{
	/**
	 * @param $title
	 *
	 * @return mixed
	 */
	function ideal_get_tournament_by_title( $title )
	{
		$tournament = ideal_get_all_tournament();
		foreach ( $tournament as $item )
		{
			if ( $item['title'] == $title )
			{
				$options[] = $item;
			}
		}
		return $options;
	}
}

if ( !function_exists( "ideal_dd" ) )
{
	/**
	 * @param string $value
	 */
	function ideal_dd( $value = "" )
	{
		var_dump( $value );
		echo "<br><pre>";
			print_r( $value );
		echo "</pre>";
		exit;
	}
}

/*
 Un-use
 */
if ( !function_exists( "ideal_get_tournament_by_id" ) )
{
	/**
	 * @param $id
	 *
	 * @return mixed|string
	 */
	function ideal_get_tournament_by_id( $id )
	{
		$tournament = ideal_get_all_tournament();
		foreach ( $tournament as $item ):
			if ( $item['id'] == $id )
			{
				return $item;
			}
		endforeach;
		return "";
	}
}

if ( !function_exists( "ideal_insert_tournament" ) )
{
	/**
	 * @param $args
	 *
	 * @return string
	 */
	function ideal_insert_tournament( $args )
	{
		$args = [ ideal_get_client_ip() =>  $args ];
		$option_name = "ideal_start_tournament";
		$options = serialize($args);
		update_option( $option_name, $options );
		return $options;
	}
}

if ( !function_exists( "ideal_get_tournament_by_ip" ) )
{
	/**
	 * @return mixed
	 */
	function ideal_get_tournament_by_ip()
	{
		$ip = ideal_get_client_ip();
		$option_name = "ideal_start_tournament";
		$tournaments = [];
		$options = get_option( $option_name );
		$options = unserialize($options);
		return $options[$ip];
	}
}

if ( !file_exists( "ideal_create_tournament_shortcode" ) )
{
	/**
	 * @param $title
	 *
	 * @return string
	 */
	function ideal_create_tournament_shortcode( $title )
	{
		$option_name = "ideal_shortcodes";
		$options = get_option($option_name);
		if (empty($options))
		{
			$options = [];
		} else {
			$options = unserialize($options);
		}
		$option = [
			"title" =>  $title
		];
		array_push( $options, $option );
		$options = serialize($options);
		update_option($option_name, $options);
		return $options;
	}
}

if ( !function_exists( "ideal_get_tournament_shortcode" ) )
{
	/**
	 * @return mixed
	 */
	function ideal_get_tournament_shortcode()
	{
		$option_name = "ideal_shortcodes";
		$options = get_option($option_name);
		$options = unserialize($options);
		return $options;
	}
}

if ( !function_exists( "ideal_delete_tournament_shortcode" ) )
{
	/**
	 * @param $id
	 *
	 * @return string
	 */
	function ideal_delete_tournament_shortcode( $id )
	{
		$option_name = "ideal_shortcodes";
		$options = ideal_get_tournament_shortcode();
		foreach ( $options as $option ):
			if ( $option['id'] == $id )
			{
				unset($option);
			} else {
				$data[] = $option;
			}
		endforeach;
		if (!empty($data))
		{
			$data = serialize($data);
		} else {
			$data = "";
		}
		update_option($option_name, $data);
		return $data;
	}
}

if ( !function_exists( "ideal_create_tournament_by_ip" ) )
{
	/**
	 * @param $key
	 *
	 * @return array
	 */
	function ideal_create_tournament_by_ip( $key )
	{
		$tournament = ideal_get_tournament_by_ip();

		$t1 = @$tournament[$key];
		$key++;
		$t2 = @$tournament[$key];
		$key++;
		return [ "i"    =>  $key,   "data"  =>  [
			$t1, $t2
		] ];
	}
}

if ( !function_exists( 'ideal_create_winner' ) )
{
	/**
	 * @param $name
	 * @param $title
	 *
	 * @return string
	 */
	function ideal_create_winner( $name, $title )
	{
		global $wpdb;
		$table = $wpdb->prefix . "ideal_winners";
		$wpdb->insert($table, ["name" => $name, "title" => $title, "votes" => 0]);
		$option_name = "ideal_winners";
		$options = get_option($option_name);
		if (empty($options))
		{
			$options = [];
			$id = 0;
		} else {
			$options = unserialize($options);
			$id = end($options)['id'];
		}
		$id++;
		$option = [
			"id"    =>  $id,
			"name"  =>  $name,
			"title" =>  $title,
			"votes" =>  0
		];
		array_push( $options, $option );
		$options = serialize($options);
		update_option( $option_name, $options );
		return $options;
	}
}

if ( !function_exists( "ideal_get_all_winners" ) )
{
	/**
	 * @return mixed
	 */
	function ideal_get_all_winners()
	{
		$option_name = "ideal_winners";
		$options = get_option( $option_name );
		$options = unserialize( $options );
		return $options;
	}
}

if ( !function_exists( "ideal_get_winners_by_title" ) )
{
	function ideal_get_winners_by_title( $title )
	{
		$winners = ideal_get_all_winners();
		foreach ( $winners as $winner ):
			if ($winner['title'] == $title)
			{
				$data[] = $winner;
			}
		endforeach;
		return $data;
	}
}

if ( !function_exists( "ideal_update_winners_table" ) )
{
	function ideal_update_winners_table($name, $title)
	{
		$i = 0;
		global $wpdb;
		$table = $wpdb->prefix . "ideal_winners";
		$result = $wpdb->get_results("SELECT * FROM $table WHERE name = '$name' AND title = '$title'");
		$name = $result[$i]->name;
		$title = $result[$i]->title;
		$votes = $result[$i]->votes + 1;
		$id = $result[$i]->id;
		$wpdb->update($table, [ "votes" => $votes ], [ "id" => $id ]);
	}
}

if ( !function_exists( "ideal_get_winner_by_name_and_title" ) )
{
	function ideal_get_winner_by_name_and_title( $name, $title )
	{
		$option_name = "ideal_winners";
		$options = ideal_get_all_winners();
		ideal_update_winners_table( $name, $title );
		foreach ( $options as $option ):
			if ( $option['title'] == $title )
			{
				if ( $option['name'] == $name )
				{
					$data[] = [
						"id"    =>  $option['id'],
						"name"  =>  $option['name'],
						"title" =>  $option['title'],
						"votes" =>  (int)$option['votes']+1
					];
				} else {
					$data[] = $option;
				}
			} else {
				$data[] = $option;
			}
		endforeach;
		$winers = serialize($data);
		update_option($option_name, $winers);
		return $winers;
	}
}

if ( !function_exists( "ideal_get_max_votes_by_title" ) )
{
	function ideal_get_max_votes_by_title( $title )
	{
		$votes = ideal_get_winners_by_title( $title );
		foreach ( $votes as $vote ):
			$vot[] = $vote['votes'];
		endforeach;
		return max($vot);
	}
}

if ( !function_exists( "ideal_get_winner_from_table" ) )
{
	/**
	 * @param $title
	 *
	 * @return array|object|null
	 */
	function ideal_get_winner_from_table( $title )
	{
		global $wpdb;
		$table = $wpdb->prefix . "ideal_winners";
		return $wpdb->get_results("SELECT * FROM $table WHERE title = '$title' ORDER BY votes DESC");
	}
}