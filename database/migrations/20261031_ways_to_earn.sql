-- Add the editable Ways to Earn homepage section if it does not already exist.
-- Images are illustrative Unsplash photographs; replace them with platform-owned assets when available.
INSERT INTO sections(type,title,eyebrow,body,theme,item_limit,sort_order,enabled)
SELECT
 'earning_grid',
 'Explore ways to earn',
 'WAYS TO EARN',
 'Choose an activity to explore. Availability, eligibility and rewards may vary.\nWatch Videos|Explore available TikTok and YouTube video activities.|https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=900&q=85&fit=crop|\nClick Ads|Discover advertising and promotional engagement tasks.|https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&q=85&fit=crop|\nWrite Blogs|Create written content through available blogging activities.|https://images.unsplash.com/photo-1455390582262-044cdead277a?w=900&q=85&fit=crop|\nAnswer Surveys|Share your opinions through available online surveys.|https://images.unsplash.com/photo-1553877522-43269d4ea984?w=900&q=85&fit=crop|\nPlay Games|Take part in eligible game-based activities.|https://images.unsplash.com/photo-1511512578047-dfb367046420?w=900&q=85&fit=crop|\nSpin to Win|Explore spin activities and check their rules before joining.|https://images.unsplash.com/photo-1606167668584-78701c57f13d?w=900&q=85&fit=crop|\nLearn Forex|Access Forex learning resources and educational activities.|https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=900&q=85&fit=crop|\nRefer Friends|Invite friends using the platform’s referral programme.|https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=900&q=85&fit=crop|',
 'soft',8,35,1
WHERE NOT EXISTS (SELECT 1 FROM sections WHERE type='earning_grid');
