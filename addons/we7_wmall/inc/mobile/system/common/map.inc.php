<?php
defined('IN_IA') || exit('Access Denied');
load()->func('communication');
global $_W;
global $_GPC;
$ta = trim($_GPC['ta']);
if ($ta == 'regeo') 
{
	$latitude = trim($_GPC['latitude']);
	$longitude = trim($_GPC['longitude']);
	$convert = intval($_GPC['convert']);
	if ($convert) 
	{
		$result = ihttp_post('http://restapi.amap.com/v3/assistant/coordinate/convert?parameters', array('locations' => $longitude . ',' . $latitude, 'coordsys' => 'gps', 'key' => '37bb6a3b1656ba7d7dc8946e7e26f39b'));
		if (is_error($result)) 
		{
			imessage(error(-1, $result['message']), '', 'ajax');
		}
		$respon = @json_decode($result['content'], true);
		$locations = $respon['locations'];
	}
	else 
	{
		$locations = $longitude . ',' . $latitude;
	}
	$query = array('output' => 'json', 'extensions' => 'all', 'key' => '37bb6a3b1656ba7d7dc8946e7e26f39b', 'location' => $locations);
	$query = http_build_query($query);
	$result = ihttp_get('http://restapi.amap.com/v3/geocode/regeo?' . $query);
	if (is_error($result)) 
	{
		imessage(error(-1, '访问出错'), '', 'ajax');
	}
	$result = @json_decode($result['content'], true);
	if (!(empty($result['regeocode']['addressComponent']['neighborhood']['name']))) 
	{
		$address = $result['regeocode']['addressComponent']['neighborhood']['name'];
	}
	else if (!(empty($result['regeocode']['aois'][0]))) 
	{
		$address = $result['regeocode']['aois'][0]['name'];
	}
	else 
	{
		$address = str_replace(array($result['regeocode']['addressComponent']['province'], $result['regeocode']['addressComponent']['district'], $result['regeocode']['addressComponent']['city'], $result['regeocode']['addressComponent']['township']), '', $result['regeocode']['formatted_address']);
	}
	foreach ($result['regeocode']['pois'] as &$item ) 
	{
		$itemold = $item;
		$location = explode(',', $item['location']);
		$item['location_y'] = $location[0];
		$item['location_x'] = $location[1];
		$item['name'] = $itemold['address'];
		$item['address'] = $itemold['name'];
	}
	$result['address'] = $address;
	$result['pois'] = $result['regeocode']['pois'];
	$result['aois'] = $result['regeocode']['aois'];
	$result['locations'] = $locations;
	$loc = explode(',', $locations);
	$result['location_y'] = $result['lng'] = $loc[0];
	$result['location_x'] = $result['lat'] = $loc[1];
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'place_around') 
{
	$latitude = trim($_GPC['latitude']);
	$longitude = trim($_GPC['longitude']);
	$query = array('output' => 'json', 'extensions' => 'all', 'key' => '37bb6a3b1656ba7d7dc8946e7e26f39b', 'location' => $longitude . ',' . $latitude, 'keywords' => $_GPC['keywords']);
	if (!(empty($_GPC['city']))) 
	{
		$query['city'] = $_GPC['city'];
	}
	if (!(empty($_GPC['radius']))) 
	{
		$query['radius'] = $_GPC['radius'];
	}
	if (!(empty($_GPC['sortrule']))) 
	{
		$query['sortrule'] = $_GPC['sortrule'];
	}
	$query = http_build_query($query);
	$result = ihttp_get('http://restapi.amap.com/v3/place/around?' . $query);
	if (is_error($result)) 
	{
		imessage(error(-1, '访问出错'), '', 'ajax');
	}
	$result = @json_decode($result['content'], true);
	if (!(empty($result['pois']))) 
	{
		foreach ($result['pois'] as &$item ) 
		{
			$itemold = $item;
			$location = explode(',', $item['location']);
			$item['location_y'] = $location[0];
			$item['location_x'] = $location[1];
			$item['name'] = $itemold['address'];
			$item['address'] = $itemold['name'];
		}
	}
	imessage(error(0, $result['pois']), '', 'ajax');
	return 1;
}
if ($ta == 'suggestion') 
{
	load()->func('communication');
	$key = trim($_GPC['key']);
	$query = array('keywords' => $key, 'city' => '全国', 'output' => 'json', 'key' => '37bb6a3b1656ba7d7dc8946e7e26f39b', 'citylimit' => 'true');
	$city = trim($_GPC['city']);
	if (!(empty($city))) 
	{
		$query['city'] = $city;
	}
	else 
	{
		$plugin = ((trim($_GPC['plugin']) ? trim($_GPC['plugin']) : 'takeout'));
		$config = $_W['we7_wmall']['config'];
		if ($plugin == 'takeout') 
		{
			$city = $config['takeout']['range']['city'];
		}
		else if ($plugin == 'errander') 
		{
			$city = get_plugin_config('errander.city');
		}
		$query['city'] = $city;
	}
	$query = http_build_query($query);
	$result = ihttp_get('http://restapi.amap.com/v3/assistant/inputtips?' . $query);
	if (is_error($result)) 
	{
		imessage(error(-1, '访问出错'), '', 'ajax');
	}
	$result = @json_decode($result['content'], true);
	if (!(empty($result['tips']))) 
	{
		$distance_sort = 0;
		foreach ($result['tips'] as $key => &$val ) 
		{
			$valold = $val;
			$val['name'] = $valold['address'];
			$val['address'] = $valold['name'];
			if (is_array($val['location'])) 
			{
				unset($val[$key]);
			}
			else 
			{
				$location = explode(',', $val['location']);
				$val['lng'] = $val['location_y'] = $location[0];
				$val['lat'] = $val['location_x'] = $location[1];
			}
			if (!(is_array($val['address']))) 
			{
				$val['address'] = $val['district'] . $val['address'];
			}
			else 
			{
				$val['address'] = $val['district'];
			}
		}
	}
	imessage(error(0, $result['tips']), '', 'ajax');
}
?>